import FacilitiesContainerComponent from './components/FacilitiesContainerComponent.vue';
import FacilitiesList from './components/FacilitiesListComponent.vue';
import FacilitiesCreate from './components/FacilitiesCreateComponent.vue';

export default [
    {
        path: '/admin/facilities',
        component: FacilitiesContainerComponent,
        children: [
            {
                path: '/',
                component: FacilitiesList,
                name: 'facilities_list'
            },
            {
                path: 'create',
                component: FacilitiesCreate,
                name: 'create_facility'
            },
            {
                path: 'edit/:id',
                component: FacilitiesCreate,
                name: 'edit_facility'
            }
        ]
    }
]