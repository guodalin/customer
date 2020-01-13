import BaseService from './base-service';

export default class CategoryService extends BaseService {
    categories() {
        return this.get('/admin/category');
    }

    store(data) {
        return this.post('/admin/category', data);
    }

    remove(id) {
        return this.delete('/admin/category/' + id);
    }
}
