import React from 'react';
import logo from './logo.svg';
import './App.css';

interface Props {
}

interface State {
    name: string
    surname: string
}

/**
 *
 */
class App extends React.Component<Props, State> {

    /**
     *
     * @param props
     */
    constructor(props: Props) {
        super(props);
        this.state = {
            name: 'React',
            surname: 'App'
        }
    }

    /**
     *
     */
    async componentDidMount() {
        const result = await fetch('http://web.localhost:8080/api/basic/info/1').then(j => j.json());
        this.setState({
            name: result.name,
            surname: result.surname
        })
    }

    render() {
        return (
            <div className="App">
                <header className="App-header">
                    <img src={logo} className="App-logo" alt="logo"/>
                    <p>
                        {this.state.name} {this.state.surname} Yes....
                    </p>
                    <a
                        className="App-link"
                        href="https://reactjs.org"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        Learn React
                    </a>
                </header>
            </div>
        )
    }
}

export default App;
