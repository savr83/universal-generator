import {ConfigActions} from '../actions'

/*
объект-наполнитель, mock-up, начальное состояние для редюсера
*/
const initialConfigState = {
    newConfigName: '',
    configs: [{id: 0, name: 'ebastos'}]
}

/*
редюсер -- чистая (pure) функция отвечающая за изменение состояния
НЕ должна менять входные параметры, не должна иметь побочных эффектов, делать API вызовы или вызовы impure функций
*/
const configReducer = (state = initialConfigState, action) => {
    switch (action.type) {
        case ConfigActions.ADD_CONFIG:
            // !!! .length не всегда длина https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/Array/length
            let newId = state.configs.length
            return {
                ...state,
                configs: [
                    ...state.configs,
                    {
                        id: newId,
                        name: action.name
                    }
                ]
            }
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
