import Dashboard from './components/pages/Dashboard';
import PageNotFound from './components/common/PageNotFound';
import userRoutes from './routes/users';
import bookRoutes from './routes/books';

/**
 * route list
 * @type {*[]}
 */
const routes = [
    {
        name: 'home',
        meta: {
            label: 'Home'
        },
        component: {
            render(c) {
                return c('router-view')
            }
        },
        path: '/',
        redirect: '/dashboard',
        children: [
            {
                component: Dashboard,
                path: 'dashboard',
                name: 'dashboard'
            },
            ...userRoutes,
            ...bookRoutes
        ]
    },
    {
        path: "*",
        component: PageNotFound
    }
];

routes.push(...bookRoutes);

export default routes;
