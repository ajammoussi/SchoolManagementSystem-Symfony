<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class userFixtures extends Fixture implements FixtureGroupInterface
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    private array $users = [
        ['amir.benali@example.com', 'ROLE_STUDENT', 'pass123'],
        ['sara.dridi@example.com', 'ROLE_STUDENT', 'pass456'],
        ['mohamed.karray@example.com', 'ROLE_STUDENT', 'pass789'],
        ['yasmine.gharbi@example.com', 'ROLE_STUDENT', 'passabc'],
        ['karim.mabrouk@example.com', 'ROLE_STUDENT', 'passdef'],
        ['ines.benamor@example.com', 'ROLE_STUDENT', 'pass123'],
        ['mehdi.saidi@example.com', 'ROLE_STUDENT', 'pass456'],
        ['lina.nouri@example.com', 'ROLE_STUDENT', 'pass789'],
        ['anis.ferjani@example.com', 'ROLE_STUDENT', 'passabc'],
        ['hiba.salhi@example.com', 'ROLE_STUDENT', 'passdef'],
        ['yassine.mejri@example.com', 'ROLE_STUDENT', 'pass123'],
        ['aya.hamdi@example.com', 'ROLE_STUDENT', 'pass456'],
        ['ali.guesmi@example.com', 'ROLE_STUDENT', 'pass789'],
        ['salma.benahmed@example.com', 'ROLE_STUDENT', 'passabc'],
        ['oussama.rekik@example.com', 'ROLE_STUDENT', 'passdef'],
        ['fatma.trabelsi@example.com', 'ROLE_STUDENT', 'pass123'],
        ['hamza.saied@example.com', 'ROLE_STUDENT', 'pass456'],
        ['lamia.ksouri@example.com', 'ROLE_STUDENT', 'pass789'],
        ['nadir.zoghlami@example.com', 'ROLE_STUDENT', 'passabc'],
        ['amina.masmoudi@example.com', 'ROLE_STUDENT', 'passdef'],
        ['mounir.bouzidi@example.com', 'ROLE_STUDENT', 'pass123'],
        ['rania.khalifa@example.com', 'ROLE_STUDENT', 'pass456'],
        ['marwen.farhat@example.com', 'ROLE_STUDENT', 'pass789'],
        ['safa.nasri@example.com', 'ROLE_STUDENT', 'passabc'],
        ['khaled.bensalah@example.com', 'ROLE_STUDENT', 'passdef'],
        ['houda.sassi@example.com', 'ROLE_STUDENT', 'pass123'],
        ['anwar.garaali@example.com', 'ROLE_STUDENT', 'pass456'],
        ['nour.hamza@example.com', 'ROLE_STUDENT', 'pass789'],
        ['wassim.harrabi@example.com', 'ROLE_STUDENT', 'passabc'],
        ['sabrine.mejri@example.com', 'ROLE_STUDENT', 'passdef'],
        ['imen.bouzidi@example.com', 'ROLE_STUDENT', 'pass123'],
        ['fares.gharsalli@example.com', 'ROLE_STUDENT', 'pass456'],
        ['amani.mabrouk@example.com', 'ROLE_STUDENT', 'pass789'],
        ['radhouane.bennaceur@example.com', 'ROLE_STUDENT', 'passabc'],
        ['hayfa.saad@example.com', 'ROLE_STUDENT', 'passdef'],
        ['achraf.dhaouadi@example.com', 'ROLE_STUDENT', 'pass123'],
        ['rym.khadhraoui@example.com', 'ROLE_STUDENT', 'pass456'],
        ['nizar.ammar@example.com', 'ROLE_STUDENT', 'pass789'],
        ['demo@insat.com', 'ROLE_STUDENT', 'demo1234'],
        ['hichem.benali@example.com', 'ROLE_TEACHER', 'pass123'],
        ['noura.chaabane@example.com', 'ROLE_TEACHER', 'pass456'],
        ['khaled.dhahri@example.com', 'ROLE_TEACHER', 'pass789'],
        ['amira.guesmi@example.com', 'ROLE_TEACHER', 'passabc'],
        ['mohamed.khelifi@example.com', 'ROLE_TEACHER', 'passdef'],
        ['ines.mabrouk@example.com', 'ROLE_TEACHER', 'pass123'],
        ['sami.nasri@example.com', 'ROLE_TEACHER', 'pass456'],
        ['yosra.ouni@example.com', 'ROLE_TEACHER', 'pass789'],
        ['adel.rahmani@example.com', 'ROLE_TEACHER', 'passabc'],
        ['lina.saidi@example.com', 'ROLE_TEACHER', 'pass123'],
        ['ahmed.trabelsi@example.com', 'ROLE_TEACHER', 'pass456'],
        ['amina.zouari@example.com', 'ROLE_TEACHER', 'pass789'],
        ['raouf.ammar@example.com', 'ROLE_TEACHER', 'passabc'],
        ['fatma.brahmi@example.com', 'ROLE_TEACHER', 'pass123'],
        ['wassim.chaieb@example.com', 'ROLE_TEACHER', 'pass456'],
        ['admin@example.com','ROLE_ADMIN', 'admin123']
    ];

    public function load(ObjectManager $manager): void
    {
        foreach ($this->users as $user) {
            $userObj = new User();
            $userObj->setEmail($user[0]);
            $userObj->setRoles([$user[1]]);

            //hash the password with the same algorithm symfony uses to compare
            $hashedPassword = $this->passwordHasher->hashPassword($userObj, $user[2]);
            $userObj->setPassword($hashedPassword);
            $manager->persist($userObj);
        }

        $manager->flush();
    }

    public function users(): array
    {
        return $this->users;
    }

    public static function getGroups(): array
    {
        return ['group4'];
    }

}