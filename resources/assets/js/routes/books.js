import List from '../components/pages/books/List.vue';
import Edit from '../components/pages/books/Edit.vue';
import Create from '../components/pages/books/Create.vue';
import View from '../components/pages/books/View.vue';

export default [{
    path: 'books',
    component: {
        render(c) {
            return c('router-view')
        }
    },
    meta: {
        label: 'Books'
    },
    redirect: '/books',
    children: [
        {
            path: '',
            component: List,
            name: 'books.index'
        },
        {
            path: 'create',
            component: Create,
            name: 'books.create',
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
            redirect: {name: 'books.show'},
            children: [
                {
                    path: '',
                    component: View,
                    name: 'books.show'
                },
                {
                    path: 'edit',
                    component: Edit,
                    name: 'books.edit',
                    meta: {
                        label: 'Edit'
                    }
                }
            ]
        }
    ]
}]
