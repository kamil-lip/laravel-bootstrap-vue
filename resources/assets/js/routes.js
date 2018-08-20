import ResourceList from './components/pages/CRUD/List';
import EditResource from './components/pages/CRUD/Edit';
import ResourceCreate from './components/pages/CRUD/Create';
import Dashboard from './components/pages/Dashboard';
import PageNotFound from './components/common/PageNotFound';

import bookRoutes from './routes/books';

/**
 * route list
 * @type {*[]}
 */
const routes = [
    {
        path: '/',
        component: Dashboard,
        props: { resourceName: 'home' },
        name: 'home'
    },
    // --- START OF CRUD ROUTES FOR USERS
    {
        path: `/users`,
        component: ResourceList,
        name: 'user.index'
    },
    {
        path: `/users/:id/edit`,
        component: EditResource,
        name: 'user.edit'
    },
    {
        path: `/users/create`,
        component: ResourceCreate,
        name: 'user.create'
    },
    // --- END OF CRUD ROUTES
    {
        path: "*",
        component: PageNotFound
    }
];



routes.push(...bookRoutes);

export default routes;
