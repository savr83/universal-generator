import React from 'react';
import {Component} from "react";
import ConfigList from "./ConfigList";
import {connect} from "react-redux";
import {addConfig, delConfig, newConfigNameUpdate} from "../../actions";
import { Button } from 'react-bootstrap';

/*
компонент-контейнер (умный, smart)
компонент-обертка для презентационных компонентов, который уже содержит состояние, логику,
отвечает за вложенные рендеринг, передачу конфигурационных параметров для дочерних компонентов
в отличие от презентационных компонентов объявляется с полным ООП синтаксисом (class, extends)

подробности:
https://reactjs.org/docs/react-component.html
жизненный цикл компонента:
http://projects.wojtekmaj.pl/react-lifecycle-methods-diagram/
*/

class ConfigListContainer extends Component {
/*
коснтруктор компонента. включает первичную обработку props, создание states
    constructor(props) {
        super(props);
    }
*/

/*
метод, вызываемый сразу после включения компонента в VirtualDOM и после первичной отрисовки
содержит инициализацию states, в том числе из внешних источников
*/
    componentDidMount() {
    }

/*
вызывается всякий раз в конце любых обновлений компонента: новые props, setState(), forceUpdate()
*/
    componentDidUpdate() {
    }

/*
вызывается перед удалением компонента -- самый последний метод
*/
    componentWillUnmount() {
    }


/*
старый код -- пересмотреть что использовать
// import { RIEToggle, RIEInput, RIETextArea, RIENumber, RIETags, RIESelect } from 'riek'

    httpTaskCallback(task) {
        axios.put('/api/configs/', {
            data: task
        })
            .then(res => {
                store.dispatch({...}); // сгенерировать экшн
                console.log(res);
                this.setState({configItems: [...this.state.configItems, res.data.data]})
            })
    };
*/

    render() {
        return (
            <div>
                <input type="text" onChange={e => this.props.newConfigNameUpdate(e.target.value)} value={this.props.newConfigName} />
                <Button className="btn btn-primary" onClick={e => this.props.addConfig(this.props.newConfigName)}>New config</Button>
                <ConfigList configs={this.props.configs} delConfig={this.props.delConfig}/>
            </div>
        );
    }
}

const mapStateToProps = function (store) {
    return {
        newConfigName: store.configState.newConfigName,
        configs: store.configState.configs
    }
}

const mapDispatchToProps = function (dispatch, ownProps) {
    return {
        addConfig: (id, name) => {
            dispatch(addConfig(id, name))
        },
        delConfig: id => {
            dispatch(delConfig(id))
        },
        newConfigNameUpdate: name => {
            dispatch(newConfigNameUpdate(name))
        }
    }
}

/*
связывание компонента с react-redux
mapStateToProps -- создает объект, ключи которого перейдут в props компонента, а значения ссылаются на ветки store приложения
mapDispatchToProps -- создает объект связывающий функции диспетчера с props компонента
*/

export default connect(mapStateToProps, mapDispatchToProps)(ConfigListContainer)
