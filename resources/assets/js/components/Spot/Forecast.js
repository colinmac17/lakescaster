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
                    //{/*<h1>Forecast for {context.state.name}</h1>*/}
                    <h2>We are still working on developing this feature. Check back soon!</h2>
                )}
            </MyContext.Consumer>
        )
    }
}

export default Forecast;