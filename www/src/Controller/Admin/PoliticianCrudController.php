<?php

namespace App\Controller\Admin;

use App\Entity\Politician;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PoliticianCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Politician::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Politician')
            ->setEntityLabelInPlural('Politician')
            ->setSearchFields(['id', 'name', 'lastname', 'slug', 'lang', 'twitter', 'image']);
    }

    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('name');
        $lastname = TextField::new('lastname');
        $slug = TextField::new('slug');
        $since = DateTimeField::new('since');
        $lang = TextField::new('lang');
        $twitter = TextField::new('twitter');
        $imageFile = Field::new('imageFile');
        $region = AssociationField::new('region');
        $contact = AssociationField::new('contact');
        $party = AssociationField::new('party');
        $politicianType = AssociationField::new('politicianType');
        $commissions = AssociationField::new('commissions');
        $image = ImageField::new('image');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$lastname, $name, $image, $region, $party, $lang, $twitter];
        } elseif (Crud::PAGE_DETAIL === $pageName) {
            return [$image];
        } elseif (Crud::PAGE_NEW === $pageName) {
            return [$name, $lastname, $slug, $since, $lang, $twitter, $imageFile, $region, $contact, $party, $politicianType, $commissions];
        } elseif (Crud::PAGE_EDIT === $pageName) {
            return [$name, $lastname, $slug, $since, $lang, $twitter, $imageFile, $region, $contact, $party, $politicianType, $commissions];
        }
    }
}
