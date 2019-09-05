import BaseService from './base-service';

export default class MenuService extends BaseService {
    menus() {
        return this.get('/admin/menu');
    }

    store(data) {
        return this.post('/admin/menu', data);
    }

    remove(menuId) {
        return this.delete('/admin/menu/' + menuId);
    }
}
