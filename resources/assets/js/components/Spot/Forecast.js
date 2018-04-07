import React, {Component, Fragment} from 'react';
import {MyContext} from '../Provider';

class Forecast extends Component{
    constructor(props){
        super(props)
        this.state = {
            data: {}
        }
    }

    render(){
        return(
            <MyContext.Consumer>
                {(context) => (
                    <h1>Forecast for {context.state.name}</h1>
                )}
            </MyContext.Consumer>
        )
    }
}

export default Forecast;