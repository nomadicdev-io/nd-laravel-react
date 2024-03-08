import PGSHeader from "./components/layouts/PGSHeader"
import PGSMain from "./components/layouts/PGSMain"
import Home from "./pages/Home"
import GlobalStyle from "./styles/GlobalStyle"

const App = () => {
  return (
    <>
      <GlobalStyle />
      <PGSHeader />
      <PGSMain>
        <Home />
      </PGSMain>
    </>
    
  )
}

export default App