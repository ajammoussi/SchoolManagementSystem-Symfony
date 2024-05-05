
// this ensures that the page is fully loaded before the script is executed
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('studentsPerYearCanvas').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: studentStatistics.map(row => 'Year '+row.studylevel),
            datasets: [{
                data: studentStatistics.map(row => row.nbStudents),
                backgroundColor: [
                    'rgba(255, 99, 132)',
                    'rgba(54, 162, 235)',
                    'rgba(255, 206, 86)',
                    'rgba(75, 192, 192)',
                    'rgba(153, 102, 255)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }

        }
    });
    

    //this part is for the absence chart
    //we need to add the missing days with 0 absences
    /*const currentdate= new Date();
    let date= new Date(currentdate);
    date.setDate(date.getDate()-20);
    
    let j=0;  
    for(let i=0; i<20; i++){
        if(absenceStatistics[j].absencedate!==formatDate(date)){
            absenceStatistics.splice(j,0,{absencedate: formatDate(date), nbAbsences: 0});
            
        }
        else{
            j++;
        }
        date.setDate(date.getDate()+1);
    }*/
    // now we sort the array by date
    absenceStatistics.sort((a, b) => new Date(a.absencedate) - new Date(b.absencedate));
    // now we can draw the chart
    const ABSENCE_CHART = document.getElementById('absenceCanvas').getContext('2d');
    new Chart(ABSENCE_CHART, {
        type: 'line',
        data: {
            labels: absenceStatistics.map(row => row.absencedate),
            datasets: [{
                data: absenceStatistics.map(row => row.nbAbsences)
            }]
        },
        options: {
            // y-axis from 0 to 5
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: 5
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    
    // this part is for the GENDER destribution chart
    console.log(genderStatistics);
    const GENDER_CHART = document.getElementById('genderCanvas').getContext('2d');
    new Chart(GENDER_CHART, {
        type: 'pie',
        data: {
            labels: genderStatistics.map(row => row.gender),
            datasets: [{
                data: genderStatistics.map(row => row.nbStudents),
                backgroundColor: [
                    'rgba(255, 99, 132)',
                    'rgba(54, 162, 235)',
                    'rgba(255, 206, 86)'
                ]
            }]
        },

        // I set these options so that the chart does not maintain its default proportions !!!!!!!!!!!
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
    const FIELD_CHART = document.getElementById('fieldCanvas').getContext('2d');
    new Chart(FIELD_CHART, {
        type: 'polarArea',
        data: {
            labels: fieldStatistics.map(row => row.field),
            datasets: [{
                data: fieldStatistics.map(row => row.nbStudents),
                backgroundColor: [
                    'rgba(255, 99, 132)',
                    'rgba(54, 162, 235)',
                    'rgba(255, 206, 86)',
                    'rgba(75, 192, 192)',
                    'rgba(153, 102, 255)',
                    'rgba(255, 159, 64)',
                    'rgba(255, 99, 71)',
                    'rgba(128, 0, 128)',
                ]
            }]
        },

        // I set these options so that the chart does not maintain its default proportions !!!!!!!!!!!
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    const abbrev_name = (str1) => {

        var split_names = str1.trim().split(" ");

        if (split_names.length > 1) {

            return (split_names[0] + " " + split_names[1].charAt(0) + ".");
        }

        return split_names[0];
    };

    const TEACHER_CHART = document.getElementById('teachersPerCourseCanvas').getContext('2d');
    new Chart(TEACHER_CHART, {
        type: 'doughnut',
        data: {
            labels: teacherStatistics.map(row => abbrev_name(row.coursename)),
            datasets: [{
                data: teacherStatistics.map(row => row.nbTeachers),
                backgroundColor: [
                    'rgba(255, 99, 132)',
                    'rgba(54, 162, 235)',
                    'rgba(255, 206, 86)',
                    'rgba(75, 192, 192)',
                    'rgba(153, 102, 255)',
                    'rgba(255, 159, 64)',
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

});



// function to format the date in the format yyyy-mm-dd
function formatDate(date) {
    const year = date.getFullYear();
    const month = (date.getMonth() + 1).toString().padStart(2, '0');
    const day = date.getDate().toString().padStart(2, '0');
    return `${year}-${month}-${day}`;
} 

