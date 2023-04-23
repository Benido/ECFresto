<?php

namespace App\Repository;

use App\Entity\BusinessHours;
use App\Enum\Weekdays;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BusinessHours>
 *
 * @method BusinessHours|null find($id, $lockMode = null, $lockVersion = null)
 * @method BusinessHours|null findOneBy(array $criteria, array $orderBy = null)
 * @method BusinessHours[]    findAll()
 * @method BusinessHours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BusinessHoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BusinessHours::class);
    }

    public function save(BusinessHours $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(BusinessHours $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllAndStringify(): array
    {
        $weeklyScheduleDraft = [];
        $weeklySchedule = $this->findAll();
        foreach ($weeklySchedule as $businessHours) {
            $weeklyScheduleDraft[] = $businessHours->getFormattedBusinessHours();
        }
        return $weeklyScheduleDraft;
    }

    public function getFormattedWeeklySchedule(): array
    {

        //Compose le tableau final représentant le planning hebdomadaire
        $formattedWeeklySchedule = [];
        foreach (Weekdays::values() as $day ) {
            $formattedWeeklySchedule[$day] = $this->dailyFormatter($day, $this->findAllAndStringify());
        }

        return $formattedWeeklySchedule;
    }

    //Formate les horaires d'ouvertures selon le jour de la semaine
    private function dailyFormatter(string $day, array $Draft ): array
    {

        $temp_array[] = array_filter($Draft, fn($a) => in_array($day, $a));
        $temp_array = array_merge(...$temp_array);
        $dailyHours = [];
        foreach($temp_array as $array) {
            //$dailyHours[] = $array[1][0] === null ? 'fermé' : $array[1];   pour l'instant géré par twig
            $dailyHours[] = $array[1];
            //echo '<pre>'; var_dump($array[1]); echo '</pre>';
        }
        return $dailyHours;
    }

    //Supprime les entrées pour un jour donné avant de soumettre les nouveaux horaires
    public function removeAndSaveNew (Array $newHours): void
    {
        //Supprime les entrées correspondant au jour des nouvelles entrées
        $weekday = $newHours[0]->getWeekdayString();
        $hoursToRemove = $this->findBy(array('weekday' => $weekday));
        foreach ($hoursToRemove as $hourItem) {
            $this->remove($hourItem);
        }
        //Ajoute les nouvelles entrées
        foreach ($newHours as $newHourItem) {
            $this->getEntityManager()->persist($newHourItem);
        }
        $this->getEntityManager()->flush();
    }

//    /**
//     * @return BusinessHours[] Returns an array of BusinessHours objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BusinessHours
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
