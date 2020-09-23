<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Templating\TemplateRegistry;

class UsersAdmin extends AbstractAdmin
{
    protected $perPageOptions = [10];
    protected $datagridValues = [
        '_per_page' => 10,
    ];
    protected $maxPerPage = 10;

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('email')
            ->add('disabled', TemplateRegistry::TYPE_BOOLEAN, [
                'editable' => false,
            ])
            ->add('_action', null, [
                'actions' => [
                    'clone' => [
                        'template' => 'CRUD/list__action_clone.html.twig',
                    ],
                ],
            ]);
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->add('disable', $this->getRouterIdParameter().'/disable');
    }
}
