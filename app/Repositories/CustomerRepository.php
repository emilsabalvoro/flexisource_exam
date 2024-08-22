<?php

namespace App\Repositories;

use DateTime;
use App\Entities\Customer;
use Doctrine\ORM\EntityManagerInterface;

/** 
 * Class CustomerRepository
 */
class CustomerRepository
{
    /**
     * customer entity class name
     * @var strings
     */
    private $entityName = Customer::class;

    /**
     * Entity manager interface
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * Class entity repository
     */
    private $entityRepository;

    /**
     * Customer repository constructor
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->entityRepository = $entityManager->getRepository($this->entityName);
    }

    /**
     * create or update customer data
     *
     * @param array $customers
     * @return void
     */
    public function createOrUpdateCustomer(array $customers): void
    {
        foreach ($customers as $customer) {
            $customerEntity = $this->entityRepository->findOneBy(['email' => $customer['email']]);

            if (!$customerEntity) {
                $customerEntity = new Customer();
                $customerEntity->setEmail($customer['email']);
                $customerEntity->setCreatedAt(new DateTime());
            } else {
                $customerEntity->setUpdatedAt(new DateTime());
            }

            $customerEntity->setFirstName($customer['first_name']);
            $customerEntity->setLastName($customer['last_name']);
            $customerEntity->setGender($customer['gender']);
            $customerEntity->setCountry($customer['country']);
            $customerEntity->setCity($customer['city']);
            $customerEntity->setUsername($customer['username']);
            $customerEntity->setPassword(md5($customer['password']));
            $customerEntity->setPhone($customer['phone']);

            $this->entityManager->persist($customerEntity);
        }

        $this->entityManager->flush();
    }

    /**
     * get all customers in database
     * @return array
     */
    public function getAllCustomer(): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('c.first_name', 'c.last_name', 'c.email', 'c.country')
            ->from($this->entityName, 'c');
            
        return $queryBuilder->getQuery()->getResult();
    }

    public function getCustomerById(int $customerId): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select(
            'c.first_name', 
            'c.last_name', 
            'c.email',
            'c.username',
            'c.gender',
            'c.country',
            'c.city',
            'c.phone'
        )->from($this->entityName, 'c')
            ->where('c.id = ' . $customerId);
            
        $result = $queryBuilder->getQuery()->getResult();
        return $result ? $result[0] : [];
    }
}