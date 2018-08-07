import ResourceList from './components/pages/CRUD/List';
import EditResource from './components/pages/CRUD/Edit';
import ResourceCreate from './components/pages/CRUD/Create';
import Dashboard from './components/pages/Dashboard';
import PageNotFound from './components/common/PageNotFound';
/**
 * route list
 * @type {*[]}
 */
export default [
    {
        path: '/',
        component: Dashboard,
        props: { resourceName: 'home' },
        name: 'home'
    },
    {
        path: '/users',
        component: ResourceList,
        props: { resourceName: 'users' },
        name: 'users.index'
    },
    {
        path: '/users/:id/edit',
        component: EditResource,
        props: { resourceName: 'users' },
        name: 'users.edit'
    },
    {
        path: '/users/create',
        component: ResourceCreate,
        props: { resourceName: 'users' },
        name: 'users.create'
    },
    {
        path: "*",
        component: PageNotFound
    }
];