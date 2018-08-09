import ResourceList from './components/pages/CRUD/List';
import EditResource from './components/pages/CRUD/Edit';
import ResourceCreate from './components/pages/CRUD/Create';
import Dashboard from './components/pages/Dashboard';
import PageNotFound from './components/common/PageNotFound';

import crudResources from './crud_resources';
let crudResourceRegex = '(' + crudResources.join('|') + ')';

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
    // --- START OF CRUD ROUTES
    {
        path: `/:resource${crudResourceRegex}`,
        component: ResourceList,
        props: { resourceName: 'users' },
        name: 'resource.index'
    },
    {
        path: `/:resource${crudResourceRegex}/:id/edit`,
        component: EditResource,
        props: { resourceName: 'users' },
        name: 'resource.edit'
    },
    {
        path: `/:resource${crudResourceRegex}/create`,
        component: ResourceCreate,
        props: { resourceName: 'users' },
        name: 'resource.create'
    },
    // --- END OF CRUD ROUTES
    {
        path: "*",
        component: PageNotFound
    }
];