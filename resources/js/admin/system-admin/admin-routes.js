import AdminsContainer from './components/AdminsContainerComponent.vue';
import AdminsList from './components/AdminsListComponent.vue';
import AdminsCreate from './components/AdminsCreateComponent.vue';

export default [
    {
        path: '/admin/system-admins',
        component: AdminsContainer,
        children: [
            {
                path: '/',
                component: AdminsList,
                name: 'admins_list'
            },
            {
                path: 'create',
                component: AdminsCreate,
                name: 'create_admin'
            },
            {
                path: 'edit/:id',
                component: AdminsCreate,
                name: 'edit_admin'
            }
        ]
    }
]