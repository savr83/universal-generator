/*
набор экшн-криэйторов и экшн-констант
экшн-криэйтор создает простой javascript объект, описывающий действие, результатом которого должно стать изменение состояния
константы используются для упрощения доступа из разных точек приложения и избежания ошибок
*/

export const addConfig = name => ({
    type: ConfigActions.ADD_CONFIG,
    name
})

export const delConfig = id => ({
    type: ConfigActions.DEL_CONFIG,
    id
})

export const newConfigNameUpdate = name => ({
    type: ConfigActions.UPD_CONFIG_NEWNAME,
    name
})

export const ConfigActions = {
    ADD_CONFIG: 'ADD_CONFIG',
    DEL_CONFIG: 'DEL_CONFIG',
    UPD_CONFIG_NEWNAME: 'UPD_CONFIG_NEWNAME',
}
