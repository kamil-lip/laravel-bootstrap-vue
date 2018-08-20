import BookList from '../components/pages/Books/List';
import EditBook from '../components/pages/Books/Edit';
import BookCreate from '../components/pages/Books/Create';

export default [
    // --- START OF CRUD ROUTES
    {
        path: `/books`,
        component: BookList,
        name: 'book.index'
    },
    {
        path: `/books/:id/edit`,
        component: EditBook,
        name: 'book.edit'
    },
    {
        path: `/books/create`,
        component: BookCreate,
        name: 'book.create'
    },
    // --- END OF CRUD ROUTES
];
