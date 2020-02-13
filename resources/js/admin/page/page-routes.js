import PagesContainer from './components/PagesContainerComponent.vue';
import PagesList from './components/PagesListComponent.vue';
import PagesCreate from './components/PagesCreateComponent.vue';
export default [
    {
        path: '/admin/pages',
        component: PagesContainer,
        children: [
            {
                path: '/',
                component: PagesList,
                name: 'pages_list'
            },
            {
                path: 'create',
                component: PagesCreate,
                name: 'create_page'
            },
            {
                path: 'edit/:id',
                component: PagesCreate,
                name: 'edit_page'
            }
        ]
    }
]