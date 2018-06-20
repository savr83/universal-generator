import { combineReducers } from 'redux'
import configReducer from './configReducer'

//import visibilityFilter from './visibilityFilter'

export default combineReducers({
    'configState': configReducer,
//    visibilityFilter
})
