import { combineReducers } from 'redux'
import configReducer from './configReducer'

/*
сборка единого редюсера из нескольких разбитых по специфике
*/

export default combineReducers({
    'configState': configReducer,
})
