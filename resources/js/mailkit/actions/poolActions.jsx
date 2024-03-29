import {apiRequest, apiSuccess, apiError} from './apiActions'

export const poolAPIList = filter => {
    return dispatch => {
        dispatch(apiRequest('list'))
        fetch('../api/pool')
            .then(res => res.json())
            .then(
                data => {
                    dispatch(apiSuccess())
                    dispatch(poolList(filter ? data.data.filter(item => item.name.search(filter)): data.data))
                },
                err => dispatch(apiError('List error!', err))
            )
    }
}

export const poolAPIAdd = (name, description) => {
    return dispatch => {
        dispatch(apiRequest('add'))
        fetch('../api/pool', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({data: { name: name, description: description}})
        })
            .then(res => res.json())
            .then(
                data => {
                    dispatch(apiSuccess())
                    dispatch(poolAdd(data.data))
                },
                err => dispatch(apiError('Add error!', err))
            );
    }
}

// todo: add all correct code
export const poolAPIDel = (id) => {
    return dispatch => {
        dispatch(apiRequest('del'))
        fetch('../api/pool', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({data: { name: name, description: description}})
        })
            .then(res => res.json())
            .then(
                data => {
                    dispatch(apiSuccess())
                    dispatch(poolAdd(data.data))
                },
                err => dispatch(apiError('Del error!', err))
            );
    }
}


export const poolList = pools => ({
    type: PoolActions.LIST,
    pools: pools
})

export const poolSelect = id => ({
    type: PoolActions.SELECT,
    id: id
})

export const poolAdd = newPool => ({
    type: PoolActions.ADD,
    newPool: newPool,
})

export const poolDel = id => ({
    type: PoolActions.DEL,
    id: id
})

export const poolUpd = (id, name, description, enabled) => ({
    type: PoolActions.UPD,
    id: id,
    name: name,
    description: description,
    enabled: enabled
})

export const PoolActions = {
    API_LIST: 'POOL_API_LIST',
    API_ADD: 'POOL_API_ADD',
    API_DEL: 'POOL_API_DEL',
    API_UPD: 'POOL_API_UPD',
    LIST: 'POOL_LIST',
    SELECT: 'POOL_SELECT',
    ADD: 'POOL_ADD',
    DEL: 'POOL_DEL',
    UPD: 'POOL_UPD',
}
