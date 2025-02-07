import { useState } from "react";

function Pagination({ offset, limit, count, endOfRecords, onPageChange }) {
    const totalPages = Math.ceil(count / limit);
    const currentPage = Math.floor(offset / limit) + 1;

    const handlePageChange = (newPage) => {
        const newOffset = (newPage - 1) * limit;
        onPageChange(newOffset);
    };

    return (
        <div className="row">
            <div className="col-lg-6">
                <ul className="pagination">
                    <li
                        className={`page-item ${
                            currentPage === 1 ? "disabled" : ""
                        }`}
                    >
                        <button
                            className="page-link"
                            onClick={() => handlePageChange(currentPage - 1)}
                        >
                            ก่อนหน้า
                        </button>
                    </li>

                    {Array.from({ length: totalPages }, (_, i) => (
                        <li
                            key={i}
                            className={`page-item ${
                                currentPage === i + 1 ? "active" : ""
                            }`}
                        >
                            <button
                                className="page-link"
                                onClick={() => handlePageChange(i + 1)}
                            >
                                {i + 1}
                            </button>
                        </li>
                    ))}

                    <li
                        className={`page-item ${
                            endOfRecords ? "disabled" : ""
                        }`}
                    >
                        <button
                            className="page-link"
                            onClick={() => handlePageChange(currentPage + 1)}
                        >
                            ถัดไป
                        </button>
                    </li>
                </ul>
            </div>
            {count && (
                <div className="col-lg-6">
                    <p className="text-muted">
                        <span className="px-1">แสดงผลลัพธ์</span>
                        <span className="fw-semibold px-1">{offset + 1}</span>-
                        <span className="fw-semibold px-1">
                            {offset + limit > count ? count : offset + limit}
                        </span>
                        <span className="px-1">จาก</span>
                        <span className="fw-semibold px-1">{count}</span>
                        รายการ
                    </p>
                </div>
            )}
        </div>
    );
}

export default Pagination;
