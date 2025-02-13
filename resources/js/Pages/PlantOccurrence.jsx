import Pagination from "@/Components/Pagination";
import Translation from "@/Components/Translation";
import VernacularName from "@/Components/VernacularName";
import BootstrapLayout from "@/Layouts/BootstrapLayout";
import { Head } from "@inertiajs/react";
import { useEffect, useState } from "react";
import dayjs from "dayjs";
import "dayjs/locale/th";
import QuickStartTheme from "@/Layouts/QuickStartTheme";

dayjs.locale("th"); // ตั้งค่าให้ใช้ภาษาไทย

const PlantOccurrence = () => {
    const [search, setSearch] = useState("");
    const [plants, setPlants] = useState([]);
    const [paginationInfo, setPaginationInfo] = useState({ offset: 0 });
    const [viewMode, setViewMode] = useState("grid"); // Default view is "grid" || "table"

    const handleSearch = async (offset = 0) => {
        const currentYear = new Date().getFullYear();
        const params = new URLSearchParams({
            q: search,
            country: "TH",
            limit: 6,
            kingdomKey: 6,
            year: `2020,${currentYear}`,
            offset: offset,
        });
        const url = `https://api.gbif.org/v1/occurrence/search?${params.toString()}`;
        // `http://localhost:8000/api/plants?search=${search}`
        // `https://api.gbif.org/v1/occurrence/search?country=TH&kingdomKey=6&limit=10`
        console.log(url);
        const response = await fetch(url);
        const data = await response.json();
        // results
        setPlants(data.results);
        const { results, ...pageInfo } = data;
        console.log(pageInfo);
        setPaginationInfo(pageInfo);
    };

    const handlePageChange = (newOffset) => {
        setPaginationInfo((prev) => ({
            ...prev,
            offset: newOffset,
            endOfRecords: newOffset + prev.limit >= prev.count,
        }));
        handleSearch(newOffset);
    };

    const ThaiTimeDisplay = (timeString) => {
        // const thaiTime = dayjs().tz("Asia/Bangkok").format("DD MMMM YYYY, HH:mm:ss");
        const year = parseInt(dayjs().year()) + 543;
        const thaiTime = dayjs(timeString).format("DD MMMM") + " " + year;

        return <span> {thaiTime}</span>;
    };

    useEffect(() => {
        handleSearch(0);
    }, [search]);

    return (
        <QuickStartTheme>
            <Head title="Plant Species Occurrence" />
            <section>
                <div className="container mt-4">
                    <h1 className="mb-4 text-center">
                        ฐานข้อมูลการอุบัติของชนิดพันธุ์พืชในประเทศไทย
                    </h1>

                    {/* View Mode Selection Dropdown */}
                    <div className="my-4 row  text-end">
                        <div className="col-lg-6 col-md-12">
                            <div className="input-group mb-3">
                                <input
                                    type="text"
                                    className="form-control"
                                    placeholder="กรอกชื่อของพืช เช่น Banana ..."
                                    value={search}
                                    onInput={(e) => setSearch(e.target.value)}
                                    onChange={(e) => setSearch(e.target.value)}
                                />
                                <button
                                    className="btn btn-primary"
                                    onClick={handleSearch}
                                >
                                    Search
                                </button>
                            </div>
                        </div>
                        <label className="col-form-label col-lg-2 col-md-6 col-sm-6 fw-bold">
                            การแสดงผล:
                        </label>
                        <div className=" col-lg-4  col-md-6 col-sm-6">
                            <select
                                className="form-select"
                                value={viewMode}
                                onChange={(e) => setViewMode(e.target.value)}
                            >
                                <option value="grid">Grid View</option>
                                <option value="table">Table View</option>
                            </select>
                        </div>
                    </div>

                    {/* Grid View */}
                    {viewMode === "grid" && (
                        <div className="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-4">
                            {plants.map((plant) => (
                                <div key={plant.key} className="col">
                                    <div className="card mb-3 h-100">
                                        <img
                                            src={
                                                plant.media[0]
                                                    ? plant.media[0].identifier
                                                    : "/img/unnamed.jpg"
                                            }
                                            className="card-img-top"
                                            alt={plant.species}
                                            style={{
                                                height: "200px",
                                                objectFit: "cover",
                                            }}
                                        />
                                        <div className="card-body">
                                            <h5 className="card-title">
                                                {plant.species} (
                                                {plant.speciesKey})
                                            </h5>
                                            <div className="card-text my-1">
                                                <span>
                                                    {plant.scientificName}
                                                </span>
                                            </div>
                                            <div className="card-text">
                                                <i className="bi-tree"></i>{" "}
                                                <VernacularName
                                                    species_key={
                                                        plant.speciesKey
                                                    }
                                                    language="EN"
                                                />
                                                <span> | </span>
                                                <VernacularName
                                                    species_key={
                                                        plant.speciesKey
                                                    }
                                                    language="TH"
                                                />
                                            </div>
                                            <div className="card-text">
                                                <i className="bi-calendar-date"></i>{" "}
                                                {ThaiTimeDisplay(
                                                    plant.eventDate
                                                )}
                                            </div>
                                            <div className="card-text">
                                                <i className="bi-geo"></i>{" "}
                                                <Translation
                                                    text={plant.stateProvince}
                                                    tags="stateProvince"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    )}

                    {/* Table View */}
                    {viewMode === "table" && (
                        <div className="table-responsive">
                            <table className="table table-striped table-bordered">
                                <thead className="table-dark">
                                    <tr>
                                        <th>Date</th>
                                        <th>Province</th>
                                        <th>Species</th>
                                        <th>Family</th>
                                        <th>Genus</th>
                                        <th>Common Name</th>
                                        <th>TH</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {plants.length > 0 ? (
                                        plants.map((plant) => (
                                            <tr key={plant.key}>
                                                <td>
                                                    {ThaiTimeDisplay(
                                                        plant.eventDate
                                                    )}
                                                </td>
                                                <td>
                                                    <Translation
                                                        text={
                                                            plant.stateProvince
                                                        }
                                                        tags="จังหวัด"
                                                    />
                                                </td>
                                                <td>{plant.species} </td>
                                                <td>{plant.family}</td>
                                                <td>{plant.genus}</td>
                                                <td>
                                                    <VernacularName
                                                        species_key={
                                                            plant.speciesKey
                                                        }
                                                        language="EN"
                                                    />
                                                </td>
                                                <td>
                                                    <VernacularName
                                                        species_key={
                                                            plant.speciesKey
                                                        }
                                                        language="TH"
                                                    />
                                                </td>
                                            </tr>
                                        ))
                                    ) : (
                                        <tr>
                                            <td
                                                colSpan="4"
                                                className="text-center"
                                            >
                                                ไม่พบข้อมูล
                                            </td>
                                        </tr>
                                    )}
                                </tbody>
                            </table>
                        </div>
                    )}
                    <div>
                        <Pagination
                            {...paginationInfo}
                            onPageChange={handlePageChange}
                        />
                    </div>
                    <div>
                        Open Data API: Powered by{" "}
                        <a href="https://www.gbif.org" target="_blank">
                            GBIF.org
                        </a>
                    </div>
                </div>
            </section>
        </QuickStartTheme>
    );
};

export default PlantOccurrence;
