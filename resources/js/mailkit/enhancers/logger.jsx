

export const logger = store => next => action => {
    console.log(`Action type:: ${action.type}, payload: ${action.payload}`)
    return next(action)
};