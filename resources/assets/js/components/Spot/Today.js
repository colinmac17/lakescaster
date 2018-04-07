import React, {Component, Fragment} from 'react';
import {MyContext} from '../Provider';

class Today extends Component{
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
                    <Fragment>
                        <h1>Today for {context.state.name}</h1>
                        <p> Weather: {context.state.data !== null ? `${context.state.data.currentWeather.iTemp} degrees` : 'Loading'} <span>{context.state.data !== null ? <img src={context.state.data.currentWeather.sIconUrl} /> : 'loading'}</span></p>
                        <p>Wave Height: {context.state.data !== null ? `${parseFloat(context.state.data.surfData[0].sWaveHeight).toFixed(2)} feet` : 'loading'}</p>
                    </Fragment>
                )}
            </MyContext.Consumer>
        )
    }
}

export default Today;