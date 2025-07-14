<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    /**
     * Giriş yapmış kullanıcının bir derse kayıt talebi göndermesini sağlar.
     * Rota: POST /api/enroll/{course_id}
     */
    public function requestEnrollment(Request $request, $course_id)
    {
        // Giriş yapmış kullanıcının ID'sini al.
        $user_id = Auth::id();

        // İstenen dersin var olup olmadığını kontrol et.
        if (!Course::find($course_id)) {
             return response()->json(['message' => 'Course not found.'], 404);
        }

        // Kullanıcı bu derse zaten talep göndermiş mi veya kayıtlı mı?
        $existingEnrollment = Enrollment::where('user_id', $user_id)
                                         ->where('course_id', $course_id)
                                         ->first();

        // Eğer daha önce talep gönderilmişse, 409 (Conflict) hatası ver.
        if ($existingEnrollment) {
            return response()->json(['message' => 'You have already requested to enroll in this course.'], 409);
        }

        // Yeni bir kayıt talebi oluştur.
        $enrollment = Enrollment::create([
            'user_id' => $user_id,
            'course_id' => $course_id,
            'status' => 'pending', // İlk durum "onay bekliyor" (pending)
        ]);

        return response()->json(['message' => 'Enrollment request sent successfully.', 'enrollment' => $enrollment], 201);
    }

    /**
     * Giriş yapmış kullanıcının kendi ders kayıtlarını listeler.
     * Rota: GET /api/my-enrollments
     */
    public function myEnrollments()
    {
        // Kullanıcının kayıtlarını, ilişkili ders bilgileriyle birlikte (`with('course')`) çek.
        $enrollments = Enrollment::where('user_id', Auth::id())->with('course')->get();
        
        return response()->json($enrollments);
    }

    /**
     * [ADMIN YETKİSİ] Sistemdeki tüm kayıt taleplerini listeler.
     * Rota: GET /api/admin/enrollments
     */
    public function listAllEnrollments()
    {
        // Tüm kayıtları, ilişkili kullanıcı ve ders bilgileriyle birlikte (`with('user', 'course')`) çek.
        $enrollments = Enrollment::with('user', 'course')->orderBy('created_at', 'desc')->get();
        return response()->json($enrollments);
    }

    /**
     * [ADMIN YETKİSİ] Bir kayıt talebinin durumunu günceller (onaylar veya reddeder).
     * Rota: PATCH /api/admin/enrollments/{enrollment_id}
     */
    public function updateEnrollmentStatus(Request $request, $enrollment_id)
    {
        // Gelen 'status' verisinin 'approved' veya 'rejected' olmasını zorunlu kıl.
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $enrollment = Enrollment::find($enrollment_id);

        // Eğer belirtilen ID ile bir kayıt bulunamazsa, 404 (Not Found) hatası ver.
        if (!$enrollment) {
            return response()->json(['message' => 'Enrollment not found.'], 404);
        }

        // Kaydın durumunu gelen yeni status ile güncelle.
        $enrollment->status = $request->status;
        $enrollment->save();

        return response()->json(['message' => 'Enrollment status updated successfully.', 'enrollment' => $enrollment]);
    }
}