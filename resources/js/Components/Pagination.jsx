import { useState } from "react";

function Pagination({ offset, limit, count, endOfRecords, onPageChange }) {
    const totalPages = Math.ceil(count / limit);
    const currentPage = Math.floor(offset / limit) + 1;

    const handlePageChange = (newPage) => {
        const newOffset = (newPage - 1) * limit;
        onPageChange(newOffset);
    };

    return (
        <nav className="d-flex flex-row justify-content-between">
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
                        Previous
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

                <li className={`page-item ${endOfRecords ? "disabled" : ""}`}>
                    <button
                        className="page-link"
                        onClick={() => handlePageChange(currentPage + 1)}
                    >
                        Next
                    </button>
                </li>
            </ul>
            {count && (
                <div>
                    <p class="text-muted">
                        <span class="px-1">แสดงผลลัพธ์</span>
                        <span class="fw-semibold px-1">{offset+1}</span>-
                        <span class="fw-semibold px-1">{ offset+limit > count ? count : offset+limit }</span>
                        <span class="px-1">จาก</span>
                        <span class="fw-semibold px-1">{count}</span>
                        รายการ
                    </p>
                </div>
            )}
        </nav>
    );
}

export default Pagination;
