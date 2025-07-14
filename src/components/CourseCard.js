import React from 'react';

const CourseCard = ({ course, onEnrollToggle }) => {
  const { id, category, title, description, startDate, duration, instructor, isEnrolled } = course;

  const handleEnrollClick = () => {
    onEnrollToggle(id);
  };

  const getCategoryStyle = (cat) => {
    const styles = {
      SPOR: { backgroundColor: '#3498db' },
      DATA: { backgroundColor: '#3498db' }, // Aynı mavi tonu
      SANAT: { backgroundColor: '#3498db' }, // Aynı mavi tonu
      ZEKA: { backgroundColor: '#3498db' }, // Aynı mavi tonu
    };
    return styles[cat.toUpperCase()] || { backgroundColor: '#95a5a6' };
  };

  return (
    <div className="course-card">
      <div className="card-header" style={getCategoryStyle(category)}>
        {category}
      </div>
      <div className="card-body">
        <h3>{title}</h3>
        <p className="description">{description}</p>
        <div className="details">
          <p><strong>Başlangıç:</strong> {startDate} • {duration}</p>
          <p><strong>Eğitmen:</strong> {instructor}</p>
        </div>
      </div>
      <div className="card-footer">
        {isEnrolled ? (
          <>
            <button className="btn btn-enrolled">Kursa Kayıtlı</button>
            <button className="btn btn-cancel" onClick={handleEnrollClick}>Kaydı İptal Et</button>
          </>
        ) : (
          <button className="btn btn-enroll" onClick={handleEnrollClick}>Kayıt Ol</button>
        )}
      </div>
    </div>
  );
};

export default CourseCard;