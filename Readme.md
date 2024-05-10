School Management System
========================

School Management System is a web platform designed to facilitate the management of schedules, attendance, exam details, and enrollment requests within a school environment. It provides separate interfaces for students, teachers, and administrators, each tailored to their specific needs.

Features
--------

- **Authentication**: The system offers a secure authentication mechanism with encrypted passwords and session ID verification.

- **Role-based Access**: There are three types of accounts:
    - **Teacher**: Can access courses, attendance records, and other relevant information.
    - **Student**: Can enroll in courses, access attendance records, view personal details, and watch online course videos.
    - **Admin**: Has access to an administrative dashboard containing statistics about students and teachers, as well as the ability to manage credentials, details, and applications to join the school.

- **Admin Dashboard**: Administrators have a dedicated dashboard to monitor and manage various aspects of the system.

- **Contact Form**: The system includes a feature for users to contact the site via email.

- **PDF Generation**: Users can generate PDFs for various purposes

Getting Started
---------------

To run the School Management System locally, follow these steps:

1. **Set Up Local Database**: Use XAMPP to start a local MySQL database and run these commands to create the database and load fixtures:
    ```bash
    
    symfony console doctrine:database:create 
    
    symfony console doctrine:migrations:execute 'DoctrineMigrations\Version20240506143517'
    
    symfony console doctrine:fixtures:load --group=group1 --purge-exclusions=user_auth
    
    symfony console doctrine:fixtures:load --group=group2 --purge-exclusions=user_auth --append
    
    symfony console doctrine:fixtures:load --group=group3 --purge-exclusions=user_auth --append
   
    symfony console doctrine:fixtures:load --group=group4 --purge-exclusions=user_auth --append
    ```
2. **Run the Server**: Start the server by running the command:
    ```bash
    symfony server:start 
    ```

3. **Access the Platform**: Open a web browser and navigate to `localhost:8000` to use and test the platform.

Demo Credentials
----------------

Use the following credentials for testing:

- **Student**:
- Email: demo@insat.com
- Password: demo1234

- **Teacher**:
- Email: mohamed.khelifi@example.com
- Password: passdef

- **Admin**:
- Email: admin@example.com
- Password: admin123

Notes
-----

- Make sure XAMPP and Symfony are properly configured and running before starting the server.

Contributors
------------

- Iyed Mdimegh
- Ahmed Jammoussi
- Maher Wali
- Abid Youssef
- Mohamed Selim Oueslati

