import LocationsContainerComponent from './components/LocationsContainerComponent.vue';
import LocationsList from './components/LocationsListComponent.vue';
import LocationsCreate from './components/LocationsCreateComponent.vue';

export default [
    {
        path: '/admin/locations',
        component: LocationsContainerComponent,
        children: [
            {
                path: '/',
                component: LocationsList,
                name: 'locations_list'
            },
            {
                path: 'create',
                component: LocationsCreate,
                name: 'create_location'
            },
            {
                path: 'edit/:id',
                component: LocationsCreate,
                name: 'edit_location'
            }
        ]
    }
]