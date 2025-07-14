<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Sistemdeki tüm dersleri listeler.
     * Bu metoda giriş yapmış herkes (admin veya normal kullanıcı) erişebilir.
     * Rota: GET /api/courses
     */
    public function index()
    {
        // Tüm dersleri veritabanından çek ve JSON olarak döndür.
        return response()->json(Course::all());
    }

    /**
     * Yeni bir ders oluşturur.
     * Bu metoda sadece 'admin' yetkisine sahip kullanıcılar erişebilir.
     * Rota: POST /api/courses
     */
    public function store(Request $request)
    {
        // Gelen verinin doğruluğunu kontrol et (validation).
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255|unique:courses', // Ders başlığı zorunlu ve daha önce kaydedilmemiş olmalı.
            'description' => 'required|string',
            'instructor' => 'required|string|max:100',
        ]);

        // Eğer doğrulama başarısız olursa, hataları 400 koduyla döndür.
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Doğrulama başarılıysa, yeni dersi oluştur.
        $course = Course::create($validator->validated());

        // Oluşturulan yeni dersi ve 201 (Created) durum kodunu döndür.
        return response()->json($course, 201);
    }

    /**
     * Belirtilen ID'ye sahip tek bir dersin detaylarını gösterir.
     * Bu metoda giriş yapmış herkes erişebilir.
     * Rota: GET /api/courses/{course}
     */
    public function show(Course $course)
    {
        // Laravel'in "Route Model Binding" özelliği sayesinde,
        // rota'daki {course} ID'sine sahip ders otomatik olarak bulunur.
        // Bulunan dersi JSON olarak döndürmek yeterlidir.
        return response()->json($course);
    }

    /**
     * Mevcut bir dersi günceller.
     * Bu metoda sadece 'admin' yetkisine sahip kullanıcılar erişebilir.
     * Rota: PUT /api/courses/{course}
     */
    public function update(Request $request, Course $course)
    {
        // Gelen veriyi doğrula. 'required' kuralı yok, çünkü sadece istenen alanlar güncellenebilir.
        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255|unique:courses,title,'.$course->id, // unique kuralı, mevcut dersin kendisi hariç tutularak kontrol edilir.
            'description' => 'string',
            'instructor' => 'string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Ders bilgilerini gelen doğrulanmış veriyle güncelle.
        $course->update($validator->validated());

        // Güncellenmiş dersi döndür.
        return response()->json($course);
    }

    /**
     * Bir dersi siler.
     * Bu metoda sadece 'admin' yetkisine sahip kullanıcılar erişebilir.
     * Rota: DELETE /api/courses/{course}
     */
    public function destroy(Course $course)
    {
        // İlgili dersi veritabanından sil.
        $course->delete();

        // Başarılı silme işleminden sonra boş bir cevap ve 204 (No Content) durum kodu döndür.
        return response()->json(null, 204);
    }
}