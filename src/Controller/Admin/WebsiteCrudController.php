<?php

namespace App\Controller\Admin;

use App\Entity\Website;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use Symfony\Bridge\Doctrine\Tests\Fixtures\AssociationEntity;

class WebsiteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Website::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom'),
            UrlField::new('url', 'Url'),
            TextEditorField::new('content', 'Description'),
            ChoiceField::new('php', 'Version php')->setChoices (['7.0 ' => '7.0', '7.1 ' => '7.1', '7.2 ' => '7.2', '7.3 ' => '7.3', '7.4 '=>  '7.4']),
            AssociationField::new('client')
            ];
    }

}
