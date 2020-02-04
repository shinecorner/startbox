import UsersContainer from './components/UsersContainerComponent.vue';
import UsersList from './components/UsersListComponent.vue';
import UsersCreate from './components/UsersCreateComponent.vue';

export default [
    {
        path: '/admin/users',
        component: UsersContainer,
        children: [
            {
                path: '/',
                component: UsersList,
                name: 'users_list'
            },
            {
                path: 'create',
                component: UsersCreate,
                name: 'create_user'
            },
            {
                path: 'edit/:id',
                component: UsersCreate,
                name: 'edit_user'
            }
        ]
    }
]