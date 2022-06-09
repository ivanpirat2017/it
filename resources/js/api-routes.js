let url = window.location.origin + '/api';

export const ServiceCreate = url + '/service-create';
export const ServiceShow_ID = url + '/service-show/';
export const ServiceShowAdmin_ID = url + '/service-show-admin/';
export const ServiceEdit = url + '/service-edit';
export const ServiceIndex_ID = url + '/service-index/';
export const ServiceDestroy = url + '/service-destroy';

export const GetCart = url + '/get-cart';

export const SearchAmdimRole = url + '/searchamdimrole';
export const SearchData= url + '/search-data';


export const Login = url + '/login';

export const Reg = url + '/register';
export const ProfilEdit = url + '/profil-edit';
export const EditRoleId = url + '/editroleid';
export const AUTH_CHECK = url + '/authcheck';
export const AUTH_ADMIN_CHECK = url + '/authcheck';
export const Logout = url + '/logout';
export const ServiceOptionCreate = url + '/service-option-create';
export const ServiceOptionDel = url + '/service-option-del';



export const CommentCreate = url + '/comment-create';
export const CommentShow_ID = url + '/comment-show';
export const CommentEdit= url + '/comment-edit';
export const CommentShowAdmin= url + '/comment-showadmin';

export const OrederCreate = url + '/oreder-create';
export const OrederGet = url + '/oreder-get';
export const OrederGetAdmin= url + '/oreder-get-admin';
export const OrederEditAdmin= url + '/oreder-edit-admin';


export async function authCheck() {
    return await fetch(AUTH_CHECK, {
        method: 'GET',
        headers: {
            "Authorization": 'Bearer ' + localStorage.getItem('token')
        }
    }).then(r => { return r });
}
export async function authAdminCheck() {
    return await fetch(AUTH_ADMIN_CHECK, {
        method: 'GET',
        headers: {
            "Authorization": 'Bearer ' + localStorage.getItem('token')
        }
    }).then(r => { return r }) ;
}
