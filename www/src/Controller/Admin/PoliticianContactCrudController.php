<?php

namespace App\Controller\Admin;

use App\Entity\PoliticianContact;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PoliticianContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PoliticianContact::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('PoliticianContact')
            ->setEntityLabelInPlural('PoliticianContact')
            ->setSearchFields(['id', 'salutation', 'prename', 'lastname', 'postSalutation', 'company', 'address1', 'address2', 'zip', 'city', 'email', 'mobile', 'phone', 'fax', 'website']);
    }

    public function configureFields(string $pageName): iterable
    {
        $salutation = TextField::new('salutation');
        $prename = TextField::new('prename');
        $lastname = TextField::new('lastname');
        $postSalutation = TextField::new('postSalutation');
        $company = TextField::new('company');
        $address1 = TextField::new('address1');
        $address2 = TextField::new('address2');
        $zip = IntegerField::new('zip');
        $city = TextField::new('city');
        $email = TextField::new('email');
        $mobile = TextField::new('mobile');
        $phone = TextField::new('phone');
        $fax = TextField::new('fax');
        $website = TextField::new('website');
        $createdAt = DateTimeField::new('createdAt');
        $updatedAt = DateTimeField::new('updatedAt');
        $id = IntegerField::new('id', 'ID');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $salutation, $prename, $lastname, $postSalutation, $company, $address1];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$id, $salutation, $prename, $lastname, $postSalutation, $company, $address1, $address2, $zip, $city, $email, $mobile, $phone, $fax, $website, $createdAt, $updatedAt];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$salutation, $prename, $lastname, $postSalutation, $company, $address1, $address2, $zip, $city, $email, $mobile, $phone, $fax, $website, $createdAt, $updatedAt];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$salutation, $prename, $lastname, $postSalutation, $company, $address1, $address2, $zip, $city, $email, $mobile, $phone, $fax, $website, $createdAt, $updatedAt];
        }
    }
}
