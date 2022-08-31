import {PoolActions} from '../actions'
import axios from "axios"

const initialState = {
    filter: '',
    dummy: {name: 'new filter', description: 'no description', enabled: true},
    updating: false,
    error: { state: false, message: '' },
    pools: [
        {id: 0, name: 'test1', description: 'No description', enabled: true},
        {id: 1, name: 'test2', description: 'Test #2', enabled: true},
        {id: 2, name: 'testZ', description: 'Disabled', enabled: false}
    ],
    selected: false
}

const poolReducer = (state = initialState, action) => {
    switch (action.type) {
        case PoolActions.API_REQUEST:
            return  {
                ...state,
                updating: true
            }
        case PoolActions.API_SUCCESS:
            return {
                ...state,
                updating: false,
            }
        case PoolActions.API_ERROR:
            return {
                ...state,
                updating: false,
                error: {state: true, message: action.error}
            }
        case PoolActions.LIST:
            return {
                ...state,
                pools: action.pools
            };
        case PoolActions.SELECT:
            return {
                ...state,
                selected: state.selected === action.id ? false : action.id
            }
        case PoolActions.ADD:
            return {
                ...state,
                pools: [
                    ...state.pools,
                    action.newPool
                ]
            }
        case PoolActions.DEL:
            return {
                ...state,
                pools: state.pools.filter(item => item.id != action.id),
                selected: false
            }
        case PoolActions.UPD:
            return {
                ...state,
                pools: state.pools.map(item => {
                    if (item.id == action.id) {
                        item.name = action.name
                    }
                    return item
                })
            }
        default:
            return state
    }
}

export default poolReducer
