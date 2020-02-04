import OrganizationsContainerComponent from './components/OrganizationsContainerComponent.vue';
import OrganizationsList from './components/OrganizationsListComponent.vue';
import OrganizationsCreate from './components/OrganizationsCreateComponent.vue';

export default [
    {
        path: '/admin/organizations',
        component: OrganizationsContainerComponent,
        children: [
            {
                path: '/',
                component: OrganizationsList,
                name: 'organizations_list'
            },
            {
                path: 'create',
                component: OrganizationsCreate,
                name: 'create_organization'
            },
            {
                path: 'edit/:id',
                component: OrganizationsCreate,
                name: 'edit_organization'
            }
        ]
    }
]