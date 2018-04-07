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
                        <div className="card text-white bg-primary mb-3">
                            <div className="card-header">Header</div>
                            <div className="card-body">
                                <h5 className="card-title">Primary card title</h5>
                                <p className="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            </div>
                        </div>
                        <h1>Today</h1>
                        <p className="today-data"> Current Temp: {context.state.data !== null ? `${Math.round(context.state.data.currentWeather.iTemp)} °F` : '...Loading'}</p>
                        <p className="today-data">Wave Height: {context.state.data !== null ? `${parseFloat(context.state.data.surfData[0].sWaveHeight).toFixed(2)} feet` : '...Loading'}</p>
                    </Fragment>
                )}
            </MyContext.Consumer>
        )
    }
}

export default Today;