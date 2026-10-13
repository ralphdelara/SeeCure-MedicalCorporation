import { Breadcrumbs } from '@/components/breadcrumbs';
import { Head, useForm, usePage } from '@inertiajs/react';
import { IconReport } from '@tabler/icons-react';
import { Button } from '@/components/ui/button';
import React, { useState } from 'react';
import { getReportData } from '@/actions/App/Http/Controllers/DashboardController';

export default function Dashboard() {
    const { data, setData, get } = useForm({
        reportType: 'vacantControlNumbers',
    });

    const submitReport = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        get(getReportData().url);
    };

    return (
        <>
            <Head title="Reports" />
            <Breadcrumbs title="Reports">&nbsp;</Breadcrumbs>
            <div className="card">
                <div className="card-body">
                    <form onSubmit={submitReport}>
                        <div className="form-group">
                            <select
                                className="form-select"
                                value={data.reportType}
                                onChange={(e) => setData('reportType', e.target.value)}
                            >
                                <option value="vacantControlNumbers">Vacant Control Numbers</option>
                                <option value="duplicatePatientNames">
                                    Duplicate Patient Names
                                </option>
                                <option value="emptyControlNumber">Empty Control Numbers</option>
                                <option value="dailyPatientVisits">Daily Patient Visits</option>
                                <option value="dailyRevenue">Daily Revenue</option>
                                <option value="monthlyRevenue">Monthly Revenue</option>
                                <option value="yearlyRevenue">Yearly Revenue</option>
                                <option value="dailyConsultationCount">
                                    Daily Consultation Count
                                </option>
                                <option value="monthlyConsultationCount">
                                    Monthly Consultation Count
                                </option>
                                <option value="yearlyConsultationCount">
                                    Yearly Consultation Count
                                </option>
                                <option value="dailyLaboratoryCount">Daily Laboratory Count</option>
                                <option value="monthlyLaboratoryCount">
                                    Monthly Laboratory Count
                                </option>
                                <option value="yearlyLaboratoryCount">
                                    Yearly Laboratory Count
                                </option>
                                <option value="dailyRadiologyCount">Daily Radiology Count</option>
                                <option value="monthlyRadiologyCount">
                                    Monthly Radiology Count
                                </option>
                                <option value="yearlyRadiologyCount">Yearly Radiology Count</option>
                            </select>
                        </div>
                        <Button size="lg">
                            <IconReport /> Generate
                        </Button>
                    </form>
                </div>
            </div>
        </>
    );
}
