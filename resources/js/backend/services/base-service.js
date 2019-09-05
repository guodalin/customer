import bus from './vue-bus';

/**
 * 基础服务
 * 定义 http
 * 以及基本的 异常处理
 */
export default class BaseService {
    constructor() {
        if (new.target === BaseService) {
            throw new Error('you should extend this class instead of initliazing it.');
        }

        this.http = axios;

        this.bus = bus;
    }

    /**
     * Get 请求
     *
     * @param {String} url
     * @param {Object|URLSearchParams} params
     *
     * @returns {Promise}
     */
    get(url, params) {
        return this.http.get(url, { params: params })
            .then(resp => resp.data)
            .catch(err => this.catch(err));
    }

    /**
     * post 请求
     *
     * @param {String} url
     * @param {FormData|File|Blob|Stream|Object|String|ArrayBuffer|URLSearchParams} data
     *
     * @returns {Promise}
     */
    post(url, data) {
        return this.http.post(url, data)
            .then(resp => resp.data)
            .catch(err => this.catch(err));
    }

    /**
     * put 请求
     *
     * @param {String} url
     * @param {FormData|File|Blob|Stream|Object|String|ArrayBuffer|URLSearchParams} data
     *
     * @returns {Promise}
     */
    put(url, data) {
        return this.http.put(url, data)
            .then(resp => resp.data)
            .catch(err => this.catch(err));
    }

    /**
     * patch 请求
     *
     * @param {String} url
     * @param {FormData|File|Blob|Stream|Object|String|ArrayBuffer|URLSearchParams} data
     *
     * @returns {Promise}
     */
    patch(url, data) {
        return this.http.patch(url, data)
            .then(resp => resp.data)
            .catch(err => this.catch(err));
    }

    /**
     * delete 请求
     *
     * @param {String} url
     * @param {Object|URLSearchParams} params
     *
     * @returns {Promise}
     */
    delete(url, params) {
        return this.http.delete(url, { params: params })
            .then(resp => resp.data)
            .catch(err => this.catch(err));
    }

    /**
     * 全局异常捕获
     *
     * 处理通用异常, 然后将额外的处理 交给 reject
     * 外部通过 catch 方法执行该回调
     *
     * @param {Object} err
     */
    catch(err) {
        const response = err.response;

        switch (response.status) {
        case 401: // authenticate
            // 推送未登录事件
            this.bus.$emit('unauthenticated');
            break;
        case 403: // authorize

            break;
        case 419: // too many attempts

            break;
        case 422: // unprocessed entity

            break;
        default:
            break;
        }

        throw response;
    }

    /**
     * 用于在独立组件之间通信的 vue 对象
     *
     * @returns {Vue}
     */
    hub() {
        return this.bus;
    }
}
