<?php

namespace App\DataFixtures;

use App\Entity\Admins;
use App\Entity\Courses;
use App\Entity\Grades;
use App\Entity\ParentUsers;
use App\Entity\Payments;
use App\Entity\Students;
use App\Entity\Teachers;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}

    public function load(ObjectManager $manager): void
    {
        // --------- ADMIN ---------
        $admin = new Admins();
        $admin->setDepartment('Direction')
              ->setPosition('Directeur')
              ->setHireDate(new \DateTimeImmutable('2020-01-01'))
              ->setIsSuperAdmin(true);
        $manager->persist($admin);

        // --------- PARENTS ---------
        $parent = new ParentUsers();
        $parent->setProfession('Ingénieur')
               ->setWorkspace('TechCorp');
        $manager->persist($parent);

        // --------- TEACHERS ---------
        $teacher = new Teachers();
        $teacher->setTeacherNumber('TCH001')
                ->setSpeciality('Mathématiques')
                ->setDepartment('Sciences')
                ->setHireDate(new \DateTimeImmutable('2019-09-01'));
        $manager->persist($teacher);

        // --------- STUDENT ---------
        $student = new Students();
        $student->setDateOfBirth(new \DateTimeImmutable('2010-05-15'))
                ->setClass('6ème A')
                ->setLevel('6ème')
                ->setAddress('123 Rue de la Paix, Paris');
        $student->addParentUser($parent);
        $manager->persist($student);

        // --------- USER ACCOUNTS ---------
        $userAdmin = new Users();
        $userAdmin->setEmail('admin@ent-facile.com')
                  ->setPassword($this->passwordHasher->hashPassword($userAdmin, 'admin123'))
                  ->setFirstName('Admin')
                  ->setLastName('Principal')
                  ->setPhone('0000000000');
        $manager->persist($userAdmin);

        $userTeacher = new Users();
        $userTeacher->setEmail('teacher@ent-facile.com')
                    ->setPassword($this->passwordHasher->hashPassword($userTeacher, 'teacher123'))
                    ->setFirstName('Jean')
                    ->setLastName('Martin')
                    ->setPhone('0123456789');
        $manager->persist($userTeacher);

        $userParent = new Users();
        $userParent->setEmail('parent@example.com')
                   ->setPassword($this->passwordHasher->hashPassword($userParent, 'parent123'))
                   ->setFirstName('Marie')
                   ->setLastName('Dupont')
                   ->setPhone('0123456789');
        $manager->persist($userParent);

        $userStudent = new Users();
        $userStudent->setEmail('student@example.com')
                    ->setPassword($this->passwordHasher->hashPassword($userStudent, 'student123'))
                    ->setFirstName('Pierre')
                    ->setLastName('Dupont')
                    ->setPhone('0123456789')
                    ->setStudents($student);
        $manager->persist($userStudent);

        // --------- COURSES ---------
        $course = new Courses();
        $course->setName('Mathématiques')
               ->setCode('MATH001')
               ->setDescription('Cours de mathématiques niveau 6ème')
               ->setHours(4)
               ->setLevel('6ème')
               ->setClass('6ème A')
               ->setCreatedAt(new \DateTimeImmutable());
        $course->addTeacher($teacher);
        $course->addStudent($student);
        $manager->persist($course);

        // --------- GRADES ---------
        $grade1 = new Grades();
        $grade1->setStudents($student)
               ->setTeachers($teacher)
               ->setValue('15.50')
               ->setType('exam')
               ->setComment('Très bon travail !')
               ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($grade1);

        $grade2 = new Grades();
        $grade2->setStudents($student)
               ->setTeachers($teacher)
               ->setValue('12.00')
               ->setType('homework')
               ->setComment('Bien, mais peut mieux faire')
               ->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($grade2);

        // --------- PAYMENT ---------
        $payment = new Payments();
        $payment->setStudents($student)
                ->setParentUsers($parent)
                ->setAmount('150.00')
                ->setType('tuition')
                ->setStatus('pending')
                ->setDescription('Frais de scolarité - Trimestre 1')
                ->setDueDate(new \DateTimeImmutable('+30 days'))
                ->setPaidAt(new \DateTimeImmutable())
                ->setCreateAt(new \DateTimeImmutable());
        $manager->persist($payment);

        // --------- FLUSH ---------
        $manager->flush();
    }
}
