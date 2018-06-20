import {ConfigActions} from '../actions'

const initialConfigState = {
    newConfigName: '',
    configs: [{id: 0, name: 'ebastos'}]
}

const configReducer = (state = initialConfigState, action) => {
    console.log('conf reducer START -- state: ', state, "action:", action)
    switch (action.type) {
        case ConfigActions.ADD_CONFIG:
            // !!! .length не всегда длина https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/Array/length
            let newId = state.configs.length
            const newState = {
                ...state,
                configs: [
                    ...state.configs,
                    {
                        id: newId,
                        name: action.name
                    }
                ]
            }
            console.log('ADD new state:', newState, "old state:", state)
            return newState
        case ConfigActions.DEL_CONFIG:
            return {
                ...state,
                configs: state.configs.filter(item => item.id != action.id)
            }
        case ConfigActions.UPD_CONFIG_NEWNAME:
            return {
                ...state,
                newConfigName: action.name
            }
        default:
            return state
    }
}

export default configReducer
