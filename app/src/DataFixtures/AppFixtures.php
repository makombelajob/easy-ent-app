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
              // --------- ADMIN EXISTANT ---------
              $admin = new Admins();
              $admin->setDepartment('Direction')
                     ->setPosition('Directeur')
                     ->setHireDate(new \DateTimeImmutable('2020-01-01'))
                     ->setIsSuperAdmin(true);
              $manager->persist($admin);

              // Ajout de 2 autres admins
              for ($i = 2; $i <= 3; $i++) {
                     $extraAdmin = new Admins();
                     $extraAdmin->setDepartment('Direction')
                            ->setPosition('Admin ' . $i)
                            ->setHireDate(new \DateTimeImmutable("2020-0{$i}-01"))
                            ->setIsSuperAdmin(false);
                     $manager->persist($extraAdmin);
              }

              // --------- PARENTS EXISTANT ---------
              $parent = new ParentUsers();
              $parent->setProfession('Ingénieur')
                     ->setWorkspace('TechCorp');
              $manager->persist($parent);

              // Ajout de 2 autres parents
              for ($i = 2; $i <= 3; $i++) {
                     $extraParent = new ParentUsers();
                     $extraParent->setProfession('Profession ' . $i)
                            ->setWorkspace('Entreprise ' . $i);
                     $manager->persist($extraParent);
              }

              // --------- TEACHERS EXISTANT ---------
              $teacher = new Teachers();
              $teacher->setTeacherNumber('TCH001')
                     ->setSpeciality('Mathématiques')
                     ->setDepartment('Sciences')
                     ->setHireDate(new \DateTimeImmutable('2019-09-01'));
              $manager->persist($teacher);

              // Ajout de 2 autres enseignants
              for ($i = 2; $i <= 3; $i++) {
                     $extraTeacher = new Teachers();
                     $extraTeacher->setTeacherNumber('TCH00' . $i)
                            ->setSpeciality('Spécialité ' . $i)
                            ->setDepartment('Département ' . $i)
                            ->setHireDate(new \DateTimeImmutable("2020-0{$i}-01"));
                     $manager->persist($extraTeacher);
              }

              // --------- STUDENT EXISTANT ---------
              $student = new Students();
              $student->setDateOfBirth(new \DateTimeImmutable('2010-05-15'))
                     ->setClass('6ème A')
                     ->setLevel('6ème')
                     ->setAddress('123 Rue de la Paix, Paris');
              $student->addParentUser($parent);
              $manager->persist($student);

              // Ajout de 2 autres étudiants
              for ($i = 2; $i <= 3; $i++) {
                     $extraStudent = new Students();
                     $extraStudent->setDateOfBirth(new \DateTimeImmutable("2010-0{$i}-15"))
                            ->setClass('6ème ' . chr(64 + $i))
                            ->setLevel('6ème')
                            ->setAddress('Adresse ' . $i);
                     $extraStudent->addParentUser($parent);
                     $manager->persist($extraStudent);
              }

              // --------- USER EXISTANTS ---------
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

              // --------- COURSES EXISTANT ---------
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

              // Ajout de 2 autres cours
              for ($i = 2; $i <= 3; $i++) {
                     $extraCourse = new Courses();
                     $extraCourse->setName('Cours ' . $i)
                            ->setCode('CODE00' . $i)
                            ->setDescription('Description cours ' . $i)
                            ->setHours(3 + $i)
                            ->setLevel('6ème')
                            ->setClass('6ème ' . chr(64 + $i))
                            ->setCreatedAt(new \DateTimeImmutable());
                     $extraCourse->addTeacher($teacher);
                     $extraCourse->addStudent($student);
                     $manager->persist($extraCourse);
              }

              // --------- GRADES EXISTANTS ---------
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

              // --------- PAYMENT EXISTANT ---------
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

              // Ajout de 2 autres paiements
              for ($i = 2; $i <= 3; $i++) {
                     $extraPayment = new Payments();
                     $extraPayment->setStudents($student)
                            ->setParentUsers($parent)
                            ->setAmount('150.00')
                            ->setType('tuition')
                            ->setStatus('pending')
                            ->setDescription('Frais de scolarité - Trimestre ' . $i)
                            ->setDueDate(new \DateTimeImmutable('+30 days'))
                            ->setPaidAt(new \DateTimeImmutable())
                            ->setCreateAt(new \DateTimeImmutable());
                     $manager->persist($extraPayment);
              }

              // --------- FLUSH ---------
              $manager->flush();
       }
}
