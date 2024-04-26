import { Navigate, Route, Routes } from "react-router-dom"
import Home from "./routes/home"
import Layouts from "./routes/layouts"
import Team from "./routes/team"
import Gallery from "./routes/gallery"
import Projects from "./routes/projects"
import UIComponents from "./routes/uicomponents"

const PGSRoutes = () => { 

  const routeData = [
    {
      path: '/',
      element: <Home />
    },
    {
      path: '/ui-components',
      element: <UIComponents />
    },
    {
      path: '/layouts',
      element: <Layouts />
    },
    {
      path: '/team',
      element: <Team />
    },
    {
      path: '/gallery',
      element: <Gallery />
    },
    {
      path: '/projects',
      element: <Projects />
    }
  ]

  return (
    <Routes>
        {
          routeData.map((item, index)=> (
            <Route path={item.path} element={ item.element} key={'route_index' + index}/>
          ))
        }
    </Routes>
  )
}

export default PGSRoutes