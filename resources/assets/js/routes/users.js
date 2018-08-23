import List from '../components/pages/users/List.vue';
import Edit from '../components/pages/users/Edit.vue';
import Create from '../components/pages/users/Create.vue';
import View from '../components/pages/users/View.vue';

export default [{
    path: 'users',
    component: {
        render(c) {
            return c('router-view')
        }
    },
    meta: {
        label: 'Users'
    },
    redirect: '/users',
    children: [
        {
            path: '',
            component: List,
            name: 'users.index'
        },
        {
            path: 'create',
            component: Create,
            name: 'users.create',
            meta: {
                label: 'Create'
            }
        },
        {
            path: ':id',
            component: {
                render(c) {
                    return c('router-view')
                }
            },
            meta: {
                label: '⌛'
            },
            redirect: {name: 'users.show'},
            children: [
                {
                    path: '',
                    component: View,
                    name: 'users.show'
                },
                {
                    path: 'edit',
                    component: Edit,
                    name: 'users.edit',
                    meta: {
                        label: 'Edit'
                    }
                }
            ]
        }
    ]
}];
