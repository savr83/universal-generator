export const poolAPIRequest = api => ({
    type: PoolActions.API_REQUEST,
    api: api
})

export const poolAPISuccess = () => ({
    type: PoolActions.API_SUCCESS,
})

export const poolAPIError = error => ({
    type: PoolActions.API_ERROR,
    error: error
})

export const poolAPIList = filter => {
    return dispatch => {
        dispatch(poolAPIRequest('list'))
        fetch('../api/pool')
            .then(res => res.json())
            .then(
                data => {
                    dispatch(poolAPISuccess())
                    dispatch(poolList(filter ? data.data.filter(item => item.name.search(filter)): data.data))
                },
                    err => dispatch(poolAPIError('fucking error!'))
            )
    }
}

export const poolAPIAdd = (name, description) => {
    return dispatch => {
        dispatch(poolAPIRequest('add'))
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
                    dispatch(poolAPISuccess())
                    dispatch(poolAdd(data.data))
                },
                err => dispatch(poolAPIError('fucking error!'))
            );
    }
}

// todo: add all correct code
export const poolAPIDel = (id) => {
    return dispatch => {
        dispatch(poolAPIRequest('del'))
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
                    dispatch(poolAPISuccess())
                    dispatch(poolAdd(data.data))
                },
                err => dispatch(poolAPIError('fucking error!'))
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
    API_REQUEST: 'POOL_API_REQUEST',
    API_SUCCESS: 'POOL_API_SUCCESS',
    API_ERROR: 'POOL_API_ERROR',
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
