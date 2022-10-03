import { combineReducers } from 'redux'
import poolReducer from './poolReducer'

export default combineReducers({
    'poolState': poolReducer,
})
