import React, { useEffect, useState } from 'react';
import CourseCard from './CourseCard';
import './CourseListPage.css';

const CourseListPage = ({ onLogout }) => {
  const [courses, setCourses] = useState([]);

  // Backend'den veri çek
  useEffect(() => {
    fetch("https://127.0.0.1:8000") // 🔁 Arkadaşının gerçek backend URL’siyle değiştir
      .then(res => res.json())
      .then(data => {
        // Her kursa isEnrolled alanı ekle
        const enrichedData = data.map(course => ({
          ...course,
          isEnrolled: false
        }));
        setCourses(enrichedData);
      })
      .catch(err => console.error("Kurslar alınamadı:", err));
  }, []);

  const handleEnrollToggle = (courseId) => {
    setCourses(prevCourses =>
      prevCourses.map(course =>
        course._id === courseId ? { ...course, isEnrolled: !course.isEnrolled } : course
      )
    );
  };

  return (
    <div className="course-list-page">
      <header className="main-header">
        <h1>Kurs Kayıt Sistemi</h1>
        <button onClick={onLogout} className="logout-button">Çıkış Yap</button>
      </header>
      <main className="main-content">
        <h2>Mevcut Kurslar</h2>
        <div className="courses-grid">
          {courses.map(course => (
            <CourseCard key={course._id} course={course} onEnrollToggle={handleEnrollToggle} />
          ))}
        </div>
      </main>
    </div>
  );
};

export default CourseListPage;
