export const addConfig = name => ({
    type: 'ADD_CONFIG',
    name
})

export const delConfig = id => ({
    type: 'DEL_CONFIG',
    id
})

export const newConfigNameUpdate = name => ({
    type: 'UPD_CONFIG_NEWNAME',
    name
})

/*​
export const toggleTodo = id => ({
    type: 'TOGGLE_TODO',
    id
})
*/

export const ConfigActions = {
    ADD_CONFIG: 'ADD_CONFIG',
    DEL_CONFIG: 'DEL_CONFIG',
    UPD_CONFIG_NEWNAME: 'UPD_CONFIG_NEWNAME',
//    SHOW_ACTIVE: 'SHOW_ACTIVE'
}
