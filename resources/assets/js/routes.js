import ResourceList from './components/CRUD/List';
import EditResource from './components/CRUD/Edit';

/**
 * route list
 * @type {*[]}
 */
export default [
    {
        path: '/users',
        component: ResourceList,
        props: { resourceName: 'users' },
        name: 'users'
    },
    {
        path: '/users/:id/edit',
        component: EditResource,
        props: { resourceName: 'users' },
        name: 'users.edit'
    },
];