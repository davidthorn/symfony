import React from 'react';

/**
 *
 */
interface Props {
    endpointUrl: string
}

/**
 *
 */
interface State {
    /**
     *
     */
    name: string

    /**
     *
     */
    surname: string
}

/**
 *
 */
class Home extends React.Component<Props, State> {

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
        const result = await fetch(`${this.props.endpointUrl}/api/basic/info/1`).then(j => j.json());
        this.setState({
            name: result.name,
            surname: result.surname
        })
    }

    render() {
        return (
            <div className="App">
                <header className="App-header">
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

export default Home;
