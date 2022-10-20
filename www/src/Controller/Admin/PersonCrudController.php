<?php

namespace App\Controller\Admin;

use App\Entity\Person;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PersonCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Person::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Person')
            ->setEntityLabelInPlural('Person')
            ->setSearchFields(['id', 'firstname', 'lastname', 'email', 'city', 'language', 'confirmationToken']);
    }

    public function configureFields(string $pageName): iterable
    {
        $firstname = TextField::new('firstname');
        $lastname = TextField::new('lastname');
        $email = TextField::new('email');
        $city = TextField::new('city');
        $language = TextField::new('language');
        $confirmed = Field::new('confirmed');
        $confirmationToken = TextField::new('confirmationToken');
        $confirmationExpires = DateTimeField::new('confirmationExpires');
        $createdAt = DateTimeField::new('createdAt');
        $updatedAt = DateTimeField::new('updatedAt');
        $campaignEntries = AssociationField::new('campaignEntries');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $firstname, $lastname, $email, $city, $language, $confirmed];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $firstname, $lastname, $email, $city, $language, $confirmed, $confirmationToken, $confirmationExpires, $createdAt, $updatedAt, $campaignEntries];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$firstname, $lastname, $email, $city, $language, $confirmed, $confirmationToken, $confirmationExpires, $createdAt, $updatedAt, $campaignEntries];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$firstname, $lastname, $email, $city, $language, $confirmed, $confirmationToken, $confirmationExpires, $createdAt, $updatedAt, $campaignEntries];
        }
    }
}
