import PGSHomeAccordian from "../../sections/PGSHomeAccordian"
import PGSHomeBadges from "../../sections/PGSHomeBadges"
import PGSHomeBanner from "../../sections/PGSHomeBanner"
import PGSHomeButtons from "../../sections/PGSHomeButtons"
import PGSHomeInfo from "../../sections/PGSHomeInfo"
import PGSHomeAlert from "../../sections/PGSHomeAlert"
import PGSHomeBreadcrumb from "../../sections/PGSHomeBreadcrumb"
import PGSHomeForms from "../../sections/PGSHomeForms"
import PGSHomeLoaders from "../../sections/PGSHomeLoaders"
import PGSHomeModal from "../../sections/PGSHomeModal"
import PGSHomePagination from "../../sections/PGSHomeLoaders"
import PGSHomeTable from "../../sections/PGSHomeTable"
import PGSHomeTabs from "../../sections/PGSHomeTabs"

const Home = () => {
  return (
    <>
    <PGSHomeBanner />
    <PGSHomeAccordian />
    <PGSHomeAlert />
    <PGSHomeBadges />
    <PGSHomeBreadcrumb />
    <PGSHomeButtons />
    <PGSHomeForms />
    <PGSHomeInfo />
    <PGSHomeLoaders />
    <PGSHomeModal />
    <PGSHomePagination />
    <PGSHomeTable />
    <PGSHomeTabs />
    </>
  )
}

export default Home