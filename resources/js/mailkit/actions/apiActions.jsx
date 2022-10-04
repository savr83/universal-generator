import { CommonActions } from '@react-navigation/native';

export const apiRequest = api => ({
    type: CommonActions.API_REQUEST,
    api: api
})

export const apiSuccess = () => ({
    type: CommonActions.API_SUCCESS,
})

export const apiError = error => ({
    type: CommonActions.API_ERROR,
    error: error
})

export const APIActions = {
    API_REQUEST: 'API_REQUEST',
    API_SUCCESS: 'API_SUCCESS',
    API_ERROR: 'API_ERROR',
}
