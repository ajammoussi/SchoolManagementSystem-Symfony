document.addEventListener("DOMContentLoaded", () => {

    const filterStudentsSelect = document.getElementById("filterStudents");
    const fieldSelect = document.getElementById("fieldSelect");
    const studyLevelSelect = document.getElementById("studyLevelSelect");
    const filterAbsencesSelect = document.getElementById("filterAbsences");
    const courseSelect = document.getElementById("courseSelect");
    const monthSelect = document.getElementById("monthSelect");
    const filterCourseFieldLevelSelect = document.getElementById("filterCourseFieldLevel")
    const tableBody = document.getElementById("body");
    const cancelButton = document.getElementById("cancel");
    const studentInfo = document.getElementById("studentInfo");
    const pageTitle = document.getElementById("pageTitle");
    const loadMoreButton = document.getElementById("loadMore");

    // Variables to keep track of the starting and ending index of the list to be shown
    var startingIndex;
    var endingIndex;


    const showMoreInfoStudent = (student) => {
        // Display the student's information in the modal

        studentInfo.innerHTML = `
            <table class="table">
                <tbody>
                <tr><th>ID</th><td>${student.id}</td></tr>
                <tr><th>First Name</th><td>${student.firstName}</td></tr>
                <tr><th>Last Name</th><td>${student.lastName}</td></tr>
                <tr><th>Email</th><td>${student.email}</td></tr>
                <tr><th>Password</th><td>${student.password}</td></tr>
                <tr><th>Phone</th><td>${student.phone}</td></tr>
                <tr><th>Address</th><td>${student.address}</td></tr>
                <tr><th>Birthdate</th><td>${student.birthdate}</td></tr>
                <tr><th>Nationality</th><td>${student.nationality}</td></tr>
                <tr><th>Gender</th><td>${student.gender}</td></tr>
                <tr><th>Field</th><td>${student.field}</td></tr>
                <tr><th>Study Level</th><td>${student.studylevel}</td></tr>
                <tr><th>Class</th><td>${student.class}</td></tr>
                </tbody>
            </table>
        `;

    };

    const showMoreInfoTeacher = (teacher) => {
        // Display the teacher's information in the modal

        studentInfo.innerHTML = `
            <table class="table">
                <tbody>
                <tr><th>ID</th><td>${teacher.id}</td></tr>
                <tr><th>First Name</th><td>${teacher.firstName}</td></tr>
                <tr><th>Last Name</th><td>${teacher.lastName}</td></tr>
                <tr><th>Email</th><td>${teacher.email}</td></tr>
                <tr><th>Password</th><td>${teacher.password}</td></tr>
                <tr><th>Phone</th><td>${teacher.phone}</td></tr>
                <tr><th>Birthdate</th><td>${teacher.gender}</td></tr>
                </tbody>
            </table>
        `;
    };

    const showStudents = (arr = students, inTeacherSection = false) => {
        tableBody.innerHTML += arr
            .map(
                (student) => {
                    let table =
                        `
                        <tr>
                            <td>${student.id}</td>
                            <td>${student.firstName}</td>
                            <td>${student.lastName}</td>
                            <td>${student.field}</td>
                            <td>${student.studylevel}</td>
                            `;
                    if (inTeacherSection) {
                        table += ` <td>${student.enrolledcourse}</td> `;
                    }
                    table += `<td><button class="btn btn-primary showMore" id="showMore${student.id}" data-bs-toggle="modal" data-bs-target="#showMoreModal">Show More</button></td>`;
                    if (inTeacherSection) {
                        table += ` <td><button class="btn btn-danger showMore" id="markAbsence${student.id}" data-bs-toggle="modal" data-bs-target="#markAbsenceModal">Mark Absence</button></td> `;
                    }
                    return table + `</tr>`;
                }

            )
            .join("");

            // Add event listeners to the "Show More" buttons
            arr.forEach((student) => {
                document.getElementById(`showMore${student.id}`).addEventListener("click", () => {
                    showMoreInfoStudent(student);
                });
            });

            // Add event listeners to the "Mark Absence" buttons
            arr.forEach((student) => {
                if (inTeacherSection) {
                    document.getElementById(`markAbsence${student.id}`).addEventListener("click", () => {
                        const studentID = document.getElementById("studentID");
                        studentID.value = student.id;
                        const courseID = document.getElementById("courseID");
                        // add to courseid.value the id of the course whoch is only the number between () in the enrolledcourse
                        courseID.value = student.enrolledcourse.match(/\(([^)]+)\)/)[1];
                        console.log(courseID.value);
                        /*// Mark absence
                        const absence = {
                            studentID: student.id,
                            studentname: student.firstname + " " + student.lastname,
                            coursename: "Math",
                            absencedate: new Date().toISOString().slice(0, 10)
                        };
                        absences.push(absence);
                        tableBody.innerHTML = "";
                        showAbsences(absences);*/
                    });
                }
            });
    };

    const showTeachers = (arr = teachers) => {
        tableBody.innerHTML += arr
            .map(
                (teacher) =>
                    `
            <tr>
                <td>${teacher.id}</td>
                <td>${teacher.firstName}</td>
                <td>${teacher.lastName}</td>
                <td>${teacher.phone}</td>
                <td><button class="btn btn-primary showMore" id="showMore${teacher.id}" data-bs-toggle="modal" data-bs-target="#Modal">Show More</button></td>
            </tr>
        `
            )
            .join("");

        // Add event listeners to the "Show More" buttons
        arr.forEach((teacher) => {
            document.getElementById(`showMore${teacher.id}`).addEventListener("click", () => {
                showMoreInfoTeacher(teacher);
            });
        });
    };

    const showAbsences = (arr = absences) => {
        tableBody.innerHTML += arr
            .map(
                (absence) =>
                    `
            <tr>
                <td>${absence.studentID}</td>
                <td>${absence.studentname}</td>
                <td>${absence.coursename}</td>
                <td>${absence.absencedate}</td>
                <td><button class="btn btn-primary" style="visibility: hidden;"></button></td>
            </tr>
        `
            )
            .join("");
    };

    const handleSingleFilterChange = (arr, filterSelect, filterFunction, showFunction) => {
        filterSelect.addEventListener("change", (choice) => {
            const selectedValue = filterSelect.value;

            // Showing the data
            tableBody.innerHTML = "";
            filteredElements = filterFunction(selectedValue);
            showFunction(filteredElements);
            cancelButton.removeAttribute("hidden");
        });
    };

    // eventListener for filtering students or absences
    const handleFilterChange = (arr, filterSelect, selectOne, selectTwo, filterOne, filterTwo, showFunction, filterFunctionOne, filterFunctionTwo) => {
        filterSelect.addEventListener("change", (choice) => {
            const selectedValue = filterSelect.value;

            // Hide all select menus
            selectOne.classList.add("hidden");
            selectTwo.classList.add("hidden");

            // Show select menu based on user's selection
            if (selectedValue === filterOne) {
                selectOne.removeAttribute("hidden");
                selectTwo.setAttribute("hidden", "");
            } else if (selectedValue === filterTwo) {
                selectTwo.removeAttribute("hidden");
                selectOne.setAttribute("hidden", "");
            } else {
                selectOne.setAttribute("hidden", "");
                selectTwo.setAttribute("hidden", "");
            }

            //Showing the data
            tableBody.innerHTML = "";
            switch (choice.target.value) {
                case filterOne:
                    selectOne.addEventListener("change", (choice) => {
                        tableBody.innerHTML = "";
                        filteredElements=filterFunctionOne(choice.target.value);
                        showFunction(filteredElements);
                        cancelButton.removeAttribute("hidden");
                    });
                    break;
                case filterTwo:
                    selectTwo.addEventListener("change", (choice) => {
                        tableBody.innerHTML = "";
                        filteredElements=filterFunctionTwo(choice.target.value);
                        showFunction(filteredElements);
                        cancelButton.removeAttribute("hidden");
                    });
                    break;
                default:
                    showFunction();
                    cancelButton.setAttribute("hidden", "");
            }
        });
    };

    // Load more students
    const fetchMoreElements = (array, showFunction) => {
        startingIndex += 8;
        endingIndex += 8;
        showFunction(array.slice(startingIndex, endingIndex));
        if (array.length <= endingIndex) {
            loadMoreButton.setAttribute("hidden", "");
        }
    };

    // not good to use innerHTML can be a vulnirability !!!!
    // reminderr!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    if (pageTitle.innerText === "Students") {
        filteredElements=students;
        startingIndex = 0;
        endingIndex = 8;

        // Show the first 8 students
        showStudents(students.slice(startingIndex, endingIndex));

        // Use the eventListener for filterStudentsSelect
        handleFilterChange(
            students,
            filterStudentsSelect,
            fieldSelect,
            studyLevelSelect,
            "field",
            "studyLevel",
            showStudents,
            (value) => students.filter((student) => student.field === value),
            (value) => students.filter((student) => student.studylevel === parseInt(value))
        );

        // Load more students
        loadMoreButton.addEventListener("click", () => {
            fetchMoreElements(filteredElements, showStudents)
        });

    } else if (pageTitle.innerHTML === "Teachers") {
        filteredElements=teachers;
        startingIndex = 0;
        endingIndex = 8;

        // Show the first 8 teachers
        showTeachers(teachers.slice(startingIndex, endingIndex));

        // Load more teachers
        loadMoreButton.addEventListener("click", () => {
            fetchMoreElements(teachers, showTeachers)
        });

    } else if (pageTitle.innerHTML === "Absences") {
        filteredElements=absences;
        startingIndex = 0;
        endingIndex = 8;

        // Show the first 8 absences
        showAbsences(absences.slice(startingIndex, endingIndex));

        // Use the eventListener for filterAbsencesSelect
        handleFilterChange(
            absences,
            filterAbsencesSelect,
            courseSelect,
            monthSelect,
            "course",
            "month",
            showAbsences,
            (value) => absences.filter((absence) => absence.coursename === value),
            (value) => absences.filter((absence) => absence.absencedate.includes('-'+String(value).padStart(2, '0')+'-'))
        );

        // Load more absences
        loadMoreButton.addEventListener("click", () => {
            fetchMoreElements(filteredElements, showAbsences)
        });
    } else if (pageTitle.innerHTML === "My Students") {
        filteredElements=students;
        startingIndex = 0;
        endingIndex = 8;

        // Show the first 8 students
        showStudents(students.slice(startingIndex, endingIndex), true);

        // Use the eventListener for filterCourseFieldLevelSelect
        handleSingleFilterChange(
            students,
            filterCourseFieldLevelSelect,
            (value) => {
                const [course, field, level] = value.split('-');
                return students.filter((student) => student.field === field && student.studylevel === parseInt(level));
            },
            (filteredStudents) => showStudents(filteredStudents, true)
        );

        // Load more students
        loadMoreButton.addEventListener("click", () => {
            fetchMoreElements(filteredElements, (filteredStudents) => showStudents(filteredStudents, true))
        });
    }





    cancelButton.addEventListener("click", () => {
        tableBody.innerHTML = "";
        if (pageTitle.innerHTML === "Students")
            showStudents();
        else if (pageTitle.innerHTML === "Absences")
            showAbsences();
        else if (pageTitle.innerHTML === "My Students")
            showStudents();
        cancelButton.setAttribute("hidden", "");
    });



});

