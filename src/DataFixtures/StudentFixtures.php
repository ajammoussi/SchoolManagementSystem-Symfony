<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class StudentFixtures extends Fixture implements FixtureGroupInterface
{
    private array $students = [
        [1, 'Amir', 'Ben Ali', 'amir.benali@example.com', 'pass123', 12345678, '123 Avenue Habib Bourguiba, Tunis', '1995-05-15', 'Male', 'Tunisian', 'GL', 2, 2],
        [2, 'Sara', 'Dridi', 'sara.dridi@example.com', 'pass456', 23456789, '45 Rue Mohamed V, Sousse', '1998-08-20', 'Female', 'Tunisian', 'RT', 3, 3],
        [3, 'Mohamed', 'Karray', 'mohamed.karray@example.com', 'pass789', 34567890, '21 Rue Farhat Hached, Sfax', '1997-02-10', 'Male', 'Tunisian', 'IIA', 2, 1],
        [4, 'Yasmine', 'Gharbi', 'yasmine.gharbi@example.com', 'passabc', 45678901, '17 Rue Habib Thameur, Bizerte', '1996-11-25', 'Female', 'Tunisian', 'IMI', 4, 3],
        [5, 'Karim', 'Mabrouk', 'karim.mabrouk@example.com', 'passdef', 56789012, '8 Avenue Mohamed Ali, Nabeul', '1999-04-05', 'Male', 'Tunisian', 'CH', 3, 2],
        [6, 'Ines', 'Ben Amor', 'ines.benamor@example.com', 'pass123', 67890123, '55 Rue Tahar Haddad, Hammamet', '1994-07-12', 'Female', 'Tunisian', 'BIO', 5, 1],
        [7, 'Mehdi', 'Saidi', 'mehdi.saidi@example.com', 'pass456', 78901234, '32 Avenue Habib Bourguiba, Tunis', '1997-09-30', 'Male', 'Tunisian', 'MPI', 1, 1],
        [8, 'Lina', 'Nouri', 'lina.nouri@example.com', 'pass789', 89012345, '29 Rue Ibn Khaldoun, Sousse', '1998-03-18', 'Female', 'Tunisian', 'CBA', 1, 3],
        [9, 'Anis', 'Ferjani', 'anis.ferjani@example.com', 'passabc', 90123456, '14 Avenue Habib Thameur, Sfax', '1995-12-03', 'Male', 'Tunisian', 'GL', 3, 1],
        [10, 'Hiba', 'Salhi', 'hiba.salhi@example.com', 'passdef', 12345678, '6 Rue Farhat Hached, Gabes', '1996-10-22', 'Female', 'Tunisian', 'RT', 4, 2],
        [11, 'Yassine', 'Mejri', 'yassine.mejri@example.com', 'pass123', 23456789, '19 Rue Mohamed V, Djerba', '1999-01-09', 'Male', 'Tunisian', 'IIA', 2, 2],
        [12, 'Aya', 'Hamdi', 'aya.hamdi@example.com', 'pass456', 34567890, '27 Avenue Habib Bourguiba, Nabeul', '1997-06-27', 'Female', 'Tunisian', 'IMI', 5, 1],
        [13, 'Ali', 'Guesmi', 'ali.guesmi@example.com', 'pass789', 45678901, '35 Rue Habib Thameur, Bizerte', '1994-04-14', 'Male', 'Tunisian', 'CH', 3, 3],
        [14, 'Salma', 'Ben Ahmed', 'salma.benahmed@example.com', 'passabc', 56789012, '11 Rue Tahar Haddad, Hammamet', '1998-11-01', 'Female', 'Tunisian', 'BIO', 4, 2],
        [15, 'Oussama', 'Rekik', 'oussama.rekik@example.com', 'passdef', 67890123, '23 Avenue Mohamed Ali, Sfax', '1996-02-28', 'Male', 'Tunisian', 'MPI', 1, 2],
        [16, 'Fatma', 'Trabelsi', 'fatma.trabelsi@example.com', 'pass123', 78901234, '39 Rue Ibn Khaldoun, Gabes', '1995-08-07', 'Female', 'Tunisian', 'CBA', 1, 1],
        [17, 'Hamza', 'Saied', 'hamza.saied@example.com', 'pass456', 89012345, '4 Avenue Habib Thameur, Tunis', '1997-03-16', 'Male', 'Tunisian', 'GL', 2, 3],
        [18, 'Lamia', 'Ksouri', 'lamia.ksouri@example.com', 'pass789', 90123456, '25 Rue Farhat Hached, Sousse', '1994-12-24', 'Female', 'Tunisian', 'RT', 3, 1],
        [19, 'Nadir', 'Zoghlami', 'nadir.zoghlami@example.com', 'passabc', 12345678, '18 Rue Mohamed V, Sfax', '1999-10-11', 'Male', 'Tunisian', 'IIA', 2, 3],
        [20, 'Amina', 'Masmoudi', 'amina.masmoudi@example.com', 'passdef', 23456789, '3 Avenue Habib Bourguiba, Bizerte', '1996-07-29', 'Female', 'Tunisian', 'IMI', 4, 2],
        [21, 'Mounir', 'Bouzidi', 'mounir.bouzidi@example.com', 'pass123', 34567890, '7 Rue Habib Thameur, Gabes', '1998-04-03', 'Male', 'Tunisian', 'CH', 3, 1],
        [22, 'Rania', 'Khalifa', 'rania.khalifa@example.com', 'pass456', 45678901, '22 Rue Tahar Haddad, Nabeul', '1997-01-14', 'Female', 'Tunisian', 'BIO', 5, 3],
        [23, 'Marwen', 'Farhat', 'marwen.farhat@example.com', 'pass789', 56789012, '16 Avenue Mohamed Ali, Hammamet', '1995-06-02', 'Male', 'Tunisian', 'MPI', 1, 3],
        [24, 'Safa', 'Nasri', 'safa.nasri@example.com', 'passabc', 67890123, '31 Rue Ibn Khaldoun, Sfax', '1994-09-21', 'Female', 'Tunisian', 'CBA', 1, 2],
        [25, 'Khaled', 'Ben Salah', 'khaled.bensalah@example.com', 'passdef', 78901234, '10 Avenue Habib Thameur, Tunis', '1998-02-18', 'Male', 'Tunisian', 'GL', 2, 1],
        [26, 'Houda', 'Sassi', 'houda.sassi@example.com', 'pass123', 89012345, '5 Rue Farhat Hached, Sousse', '1995-05-10', 'Female', 'Tunisian', 'RT', 4, 3],
        [27, 'Anwar', 'Garaali', 'anwar.garaali@example.com', 'pass456', 90123456, '2 Avenue Mohamed Ali, Sfax', '1996-12-01', 'Male', 'Tunisian', 'IIA', 2, 2],
        [28, 'Nour', 'Hamza', 'nour.hamza@example.com', 'pass789', 12345678, '9 Rue Habib Thameur, Bizerte', '1999-08-08', 'Female', 'Tunisian', 'IMI', 3, 1],
        [29, 'Wassim', 'Harrabi', 'wassim.harrabi@example.com', 'passabc', 23456789, '13 Rue Tahar Haddad, Nabeul', '1997-04-17', 'Male', 'Tunisian', 'CH', 3, 2],
        [30, 'Sabrine', 'Mejri', 'sabrine.mejri@example.com', 'passdef', 34567890, '20 Avenue Mohamed Ali, Hammamet', '1994-11-22', 'Female', 'Tunisian', 'BIO', 4, 1],
        [31, 'Imen', 'Bouzidi', 'imen.bouzidi@example.com', 'pass123', 45678901, '28 Rue Ibn Khaldoun, Gabes', '1996-06-19', 'Female', 'Tunisian', 'MPI', 1, 2],
        [32, 'Fares', 'Gharsalli', 'fares.gharsalli@example.com', 'pass456', 56789012, '37 Avenue Habib Thameur, Tunis', '1999-03-02', 'Male', 'Tunisian', 'CBA', 1, 3],
        [33, 'Amani', 'Mabrouk', 'amani.mabrouk@example.com', 'pass789', 67890123, '30 Rue Farhat Hached, Sousse', '1994-10-13', 'Female', 'Tunisian', 'GL', 2, 1],
        [34, 'Radhouane', 'Bennaceur', 'radhouane.bennaceur@example.com', 'passabc', 78901234, '15 Rue Mohamed V, Sfax', '1997-07-30', 'Male', 'Tunisian', 'RT', 3, 2],
        [35, 'Hayfa', 'Saad', 'hayfa.saad@example.com', 'passdef', 89012345, '24 Avenue Habib Bourguiba, Bizerte', '1995-02-11', 'Female', 'Tunisian', 'IIA', 2, 3],
        [36, 'Achraf', 'Dhaouadi', 'achraf.dhaouadi@example.com', 'pass123', 90123456, '36 Rue Habib Thameur, Nabeul', '1998-09-29', 'Male', 'Tunisian', 'IMI', 5, 2],
        [37, 'Rym', 'Khadhraoui', 'rym.khadhraoui@example.com', 'pass456', 12345678, '1 Rue Tahar Haddad, Hammamet', '1996-04-26', 'Female', 'Tunisian', 'CH', 3, 1],
        [38, 'Nizar', 'Ammar', 'nizar.ammar@example.com', 'pass789', 23456789, '26 Avenue Mohamed Ali, Sousse', '1999-11-03', 'Male', 'Tunisian', 'BIO', 4, 3],
        [39, 'foulen', 'fouleni','demo@insat.com', 'demo1234', 12345678, '5 Rue de la Liberté Tunis', '1999-01-01', 'Male', 'Tunisian', 'GL',  2,   2]
    ];

    public function load(ObjectManager $manager): void
    {
        foreach ($this->students as $student) {
            $studentObj = new \App\Entity\Student();
            $studentObj->setId($student[0]);
            $studentObj->setFirstName($student[1]);
            $studentObj->setLastName($student[2]);
            $studentObj->setEmail($student[3]);
            $studentObj->setPassword($student[4]);
            $studentObj->setPhone($student[5]);
            $studentObj->setAddress($student[6]);
            $studentObj->setBirthDate(new \DateTime($student[7]));
            $studentObj->setGender($student[8]);
            $studentObj->setNationality($student[9]);
            $studentObj->setField($student[10]);
            $studentObj->setStudylevel($student[11]);
            $studentObj->setClass($student[12]);
            $manager->persist($studentObj);
        }

        $manager->flush();
    }

    public function getStudents(): array
    {
        return $this->students;
    }

    public static function getGroups(): array
    {
        return ['group1'];
    }

}
