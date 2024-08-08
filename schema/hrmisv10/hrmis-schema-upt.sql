# Remove unused Tables that does not exist in updated schema
# Remove unused Tables...
# Add necessary Tables...

# Fix DateTime field in table tblAgency
ALTER TABLE `tblAgency` CHANGE `expirationCTO` `expirationCTO` VARCHAR(20) DEFAULT NULL;
UPDATE `tblAgency` SET `expirationCTO` = NULL WHERE `expirationCTO` LIKE '0000%' OR `expirationCTO` LIKE '%-00-%' OR `expirationCTO` LIKE '%-00';
ALTER TABLE `tblAgency` CHANGE `expirationCTO` `expirationCTO` DATETIME DEFAULT NULL;
# Fix Date Value 
# Fix DateTime field in table tblBrokenSched
ALTER TABLE `tblBrokenSched` CHANGE `dateFrom` `dateFrom` VARCHAR(20) DEFAULT NULL,CHANGE `dateTo` `dateTo` VARCHAR(20) DEFAULT NULL;
UPDATE `tblBrokenSched` SET `dateFrom` = NULL WHERE `dateFrom` LIKE '0000%' OR `dateFrom` LIKE '%-00-%' OR `dateFrom` LIKE '%-00';
UPDATE `tblBrokenSched` SET `dateTo` = NULL WHERE `dateTo` LIKE '0000%' OR `dateTo` LIKE '%-00-%' OR `dateTo` LIKE '%-00';
ALTER TABLE `tblBrokenSched` CHANGE `dateFrom` `dateFrom` DATE DEFAULT NULL,CHANGE `dateTo` `dateTo` DATE DEFAULT NULL;
# Fix DateTime field in table tblChangeLog
ALTER TABLE `tblChangeLog` CHANGE `date_time` `date_time` VARCHAR(20) DEFAULT NULL;
UPDATE `tblChangeLog` SET `date_time` = NULL WHERE `date_time` LIKE '0000%' OR `date_time` LIKE '%-00-%' OR `date_time` LIKE '%-00';
ALTER TABLE `tblChangeLog` CHANGE `date_time` `date_time` DATETIME DEFAULT NULL;
# Fix Date Value 
# Fix DateTime field in table tblEmpAppointment
ALTER TABLE `tblEmpAppointment` CHANGE `dateIssued` `dateIssued` VARCHAR(20) DEFAULT NULL,CHANGE `datePublished` `datePublished` VARCHAR(20) DEFAULT NULL;
UPDATE `tblEmpAppointment` SET `dateIssued` = NULL WHERE `dateIssued` LIKE '0000%' OR `dateIssued` LIKE '%-00-%' OR `dateIssued` LIKE '%-00';
UPDATE `tblEmpAppointment` SET `datePublished` = NULL WHERE `datePublished` LIKE '0000%' OR `datePublished` LIKE '%-00-%' OR `datePublished` LIKE '%-00';
ALTER TABLE `tblEmpAppointment` CHANGE `dateIssued` `dateIssued` DATE DEFAULT NULL,CHANGE `datePublished` `datePublished` DATE DEFAULT NULL;
# Fix Date Value 
# Fix DateTime field in table tblEmpChild
ALTER TABLE `tblEmpChild` CHANGE `childBirthDate` `childBirthDate` VARCHAR(20) DEFAULT NULL;
UPDATE `tblEmpChild` SET `childBirthDate` = NULL WHERE `childBirthDate` LIKE '0000%' OR `childBirthDate` LIKE '%-00-%' OR `childBirthDate` LIKE '%-00';
ALTER TABLE `tblEmpChild` CHANGE `childBirthDate` `childBirthDate` DATE DEFAULT NULL;
# Fix Date Value 
# Fix DateTime field in table tblEmpDTR
ALTER TABLE `tblEmpDTR` CHANGE `dtrDate` `dtrDate` VARCHAR(20) DEFAULT NULL;
UPDATE `tblEmpDTR` SET `dtrDate` = NULL WHERE `dtrDate` LIKE '0000%' OR `dtrDate` LIKE '%-00-%' OR `dtrDate` LIKE '%-00';
ALTER TABLE `tblEmpDTR` CHANGE `dtrDate` `dtrDate` DATE DEFAULT NULL;
# Fix DateTime field in table tblEmpDTR_log
ALTER TABLE `tblEmpDTR_log` CHANGE `log_date` `log_date` VARCHAR(20) DEFAULT NULL;
UPDATE `tblEmpDTR_log` SET `log_date` = NULL WHERE `log_date` LIKE '0000%' OR `log_date` LIKE '%-00-%' OR `log_date` LIKE '%-00';
ALTER TABLE `tblEmpDTR_log` CHANGE `log_date` `log_date` DATETIME DEFAULT NULL;
# Fix Date Value 
# Fix DateTime field in table tblEmpDeductLoan
ALTER TABLE `tblEmpDeductLoan` CHANGE `dateGranted` `dateGranted` VARCHAR(20) DEFAULT NULL;
UPDATE `tblEmpDeductLoan` SET `dateGranted` = NULL WHERE `dateGranted` LIKE '0000%' OR `dateGranted` LIKE '%-00-%' OR `dateGranted` LIKE '%-00';
ALTER TABLE `tblEmpDeductLoan` CHANGE `dateGranted` `dateGranted` DATE DEFAULT NULL;
# Fix Date Value 
# Fix DateTime field in table tblEmpDeductionRemit
ALTER TABLE `tblEmpDeductionRemit` CHANGE `orDate` `orDate` VARCHAR(20) DEFAULT NULL;
UPDATE `tblEmpDeductionRemit` SET `orDate` = NULL WHERE `orDate` LIKE '0000%' OR `orDate` LIKE '%-00-%' OR `orDate` LIKE '%-00';
ALTER TABLE `tblEmpDeductionRemit` CHANGE `orDate` `orDate` DATE DEFAULT NULL;
# Fix Date Value 
# Fix DateTime field in table tblEmpDeductions
ALTER TABLE `tblEmpDeductions` CHANGE `dateGranted` `dateGranted` VARCHAR(20) DEFAULT NULL;
UPDATE `tblEmpDeductions` SET `dateGranted` = NULL WHERE `dateGranted` LIKE '0000%' OR `dateGranted` LIKE '%-00-%' OR `dateGranted` LIKE '%-00';
ALTER TABLE `tblEmpDeductions` CHANGE `dateGranted` `dateGranted` DATE DEFAULT NULL;
# Fix Date Value 
# Fix DateTime field in table tblEmpExam
ALTER TABLE `tblEmpExam` CHANGE `examDate` `examDate` VARCHAR(20) DEFAULT NULL,CHANGE `dateRelease` `dateRelease` VARCHAR(20) DEFAULT NULL;
UPDATE `tblEmpExam` SET `examDate` = NULL WHERE `examDate` LIKE '0000%' OR `examDate` LIKE '%-00-%' OR `examDate` LIKE '%-00';
UPDATE `tblEmpExam` SET `dateRelease` = NULL WHERE `dateRelease` LIKE '0000%' OR `dateRelease` LIKE '%-00-%' OR `dateRelease` LIKE '%-00';
ALTER TABLE `tblEmpExam` CHANGE `examDate` `examDate` DATE DEFAULT NULL,CHANGE `dateRelease` `dateRelease` DATE DEFAULT NULL;
# Fix Date Value 
# Fix DateTime field in table tblEmpLeave
ALTER TABLE `tblEmpLeave` CHANGE `dateFiled` `dateFiled` VARCHAR(20) DEFAULT NULL,CHANGE `leaveFrom` `leaveFrom` VARCHAR(20) DEFAULT NULL,CHANGE `leaveTo` `leaveTo` VARCHAR(20) DEFAULT NULL;
UPDATE `tblEmpLeave` SET `dateFiled` = NULL WHERE `dateFiled` LIKE '0000%' OR `dateFiled` LIKE '%-00-%' OR `dateFiled` LIKE '%-00';
UPDATE `tblEmpLeave` SET `leaveFrom` = NULL WHERE `leaveFrom` LIKE '0000%' OR `leaveFrom` LIKE '%-00-%' OR `leaveFrom` LIKE '%-00';
UPDATE `tblEmpLeave` SET `leaveTo` = NULL WHERE `leaveTo` LIKE '0000%' OR `leaveTo` LIKE '%-00-%' OR `leaveTo` LIKE '%-00';
ALTER TABLE `tblEmpLeave` CHANGE `dateFiled` `dateFiled` DATE DEFAULT NULL,CHANGE `leaveFrom` `leaveFrom` DATE DEFAULT NULL,CHANGE `leaveTo` `leaveTo` DATE DEFAULT NULL;
# Fix DateTime field in table tblEmpLeaveBalance
ALTER TABLE `tblEmpLeaveBalance` CHANGE `processDate` `processDate` VARCHAR(20) DEFAULT NULL;
UPDATE `tblEmpLeaveBalance` SET `processDate` = NULL WHERE `processDate` LIKE '0000%' OR `processDate` LIKE '%-00-%' OR `processDate` LIKE '%-00';
ALTER TABLE `tblEmpLeaveBalance` CHANGE `processDate` `processDate` DATETIME DEFAULT NULL;
# Fix Date Value 
# Fix DateTime field in table tblEmpLongevity
ALTER TABLE `tblEmpLongevity` CHANGE `longiDate` `longiDate` VARCHAR(20) DEFAULT NULL;
UPDATE `tblEmpLongevity` SET `longiDate` = NULL WHERE `longiDate` LIKE '0000%' OR `longiDate` LIKE '%-00-%' OR `longiDate` LIKE '%-00';
ALTER TABLE `tblEmpLongevity` CHANGE `longiDate` `longiDate` DATE DEFAULT NULL;
# Fix Date Value 
# Fix DateTime field in table tblEmpMeeting
ALTER TABLE `tblEmpMeeting` CHANGE `dateFiled` `dateFiled` VARCHAR(20) DEFAULT NULL,CHANGE `meetingDate` `meetingDate` VARCHAR(20) DEFAULT NULL;
UPDATE `tblEmpMeeting` SET `dateFiled` = NULL WHERE `dateFiled` LIKE '0000%' OR `dateFiled` LIKE '%-00-%' OR `dateFiled` LIKE '%-00';
UPDATE `tblEmpMeeting` SET `meetingDate` = NULL WHERE `meetingDate` LIKE '0000%' OR `meetingDate` LIKE '%-00-%' OR `meetingDate` LIKE '%-00';
ALTER TABLE `tblEmpMeeting` CHANGE `dateFiled` `dateFiled` DATE DEFAULT NULL,CHANGE `meetingDate` `meetingDate` DATE DEFAULT NULL;
# Fix DateTime field in table tblEmpMonetization
ALTER TABLE `tblEmpMonetization` CHANGE `processDate` `processDate` VARCHAR(20) DEFAULT NULL;
UPDATE `tblEmpMonetization` SET `processDate` = NULL WHERE `processDate` LIKE '0000%' OR `processDate` LIKE '%-00-%' OR `processDate` LIKE '%-00';
ALTER TABLE `tblEmpMonetization` CHANGE `processDate` `processDate` DATETIME DEFAULT NULL;
# Fix Date Value 
# Fix DateTime field in table tblEmpOB
ALTER TABLE `tblEmpOB` CHANGE `dateFiled` `dateFiled` VARCHAR(20) DEFAULT NULL,CHANGE `obDateFrom` `obDateFrom` VARCHAR(20) DEFAULT NULL,CHANGE `obDateTo` `obDateTo` VARCHAR(20) DEFAULT NULL;
UPDATE `tblEmpOB` SET `dateFiled` = NULL WHERE `dateFiled` LIKE '0000%' OR `dateFiled` LIKE '%-00-%' OR `dateFiled` LIKE '%-00';
UPDATE `tblEmpOB` SET `obDateFrom` = NULL WHERE `obDateFrom` LIKE '0000%' OR `obDateFrom` LIKE '%-00-%' OR `obDateFrom` LIKE '%-00';
UPDATE `tblEmpOB` SET `obDateTo` = NULL WHERE `obDateTo` LIKE '0000%' OR `obDateTo` LIKE '%-00-%' OR `obDateTo` LIKE '%-00';
ALTER TABLE `tblEmpOB` CHANGE `dateFiled` `dateFiled` DATE DEFAULT NULL,CHANGE `obDateFrom` `obDateFrom` DATE DEFAULT NULL,CHANGE `obDateTo` `obDateTo` DATE DEFAULT NULL;
# Fix Date Value 
# Fix DateTime field in table tblEmpOtherSched
ALTER TABLE `tblEmpOtherSched` CHANGE `fromDate` `fromDate` VARCHAR(20) DEFAULT NULL,CHANGE `toDate` `toDate` VARCHAR(20) DEFAULT NULL;
UPDATE `tblEmpOtherSched` SET `fromDate` = NULL WHERE `fromDate` LIKE '0000%' OR `fromDate` LIKE '%-00-%' OR `fromDate` LIKE '%-00';
UPDATE `tblEmpOtherSched` SET `toDate` = NULL WHERE `toDate` LIKE '0000%' OR `toDate` LIKE '%-00-%' OR `toDate` LIKE '%-00';
ALTER TABLE `tblEmpOtherSched` CHANGE `fromDate` `fromDate` DATE DEFAULT NULL,CHANGE `toDate` `toDate` DATE DEFAULT NULL;
# Fix Date Value 
# Fix DateTime field in table tblEmpOvertime
ALTER TABLE `tblEmpOvertime` CHANGE `dateFiled` `dateFiled` VARCHAR(20) DEFAULT NULL,CHANGE `otDateFrom` `otDateFrom` VARCHAR(20) DEFAULT NULL,CHANGE `otDateTo` `otDateTo` VARCHAR(20) DEFAULT NULL;
UPDATE `tblEmpOvertime` SET `dateFiled` = NULL WHERE `dateFiled` LIKE '0000%' OR `dateFiled` LIKE '%-00-%' OR `dateFiled` LIKE '%-00';
UPDATE `tblEmpOvertime` SET `otDateFrom` = NULL WHERE `otDateFrom` LIKE '0000%' OR `otDateFrom` LIKE '%-00-%' OR `otDateFrom` LIKE '%-00';
UPDATE `tblEmpOvertime` SET `otDateTo` = NULL WHERE `otDateTo` LIKE '0000%' OR `otDateTo` LIKE '%-00-%' OR `otDateTo` LIKE '%-00';
ALTER TABLE `tblEmpOvertime` CHANGE `dateFiled` `dateFiled` DATE DEFAULT NULL,CHANGE `otDateFrom` `otDateFrom` DATE DEFAULT NULL,CHANGE `otDateTo` `otDateTo` DATE DEFAULT NULL;
# Fix Date Value 
# Fix DateTime field in table tblEmpPersonal
ALTER TABLE `tblEmpPersonal` CHANGE `birthday` `birthday` VARCHAR(20) DEFAULT NULL,CHANGE `dateAccomplished` `dateAccomplished` VARCHAR(20) DEFAULT NULL,CHANGE `issuedOn` `issuedOn` VARCHAR(20) DEFAULT NULL;
UPDATE `tblEmpPersonal` SET `birthday` = NULL WHERE `birthday` LIKE '0000%' OR `birthday` LIKE '%-00-%' OR `birthday` LIKE '%-00';
UPDATE `tblEmpPersonal` SET `dateAccomplished` = NULL WHERE `dateAccomplished` LIKE '0000%' OR `dateAccomplished` LIKE '%-00-%' OR `dateAccomplished` LIKE '%-00';
UPDATE `tblEmpPersonal` SET `issuedOn` = NULL WHERE `issuedOn` LIKE '0000%' OR `issuedOn` LIKE '%-00-%' OR `issuedOn` LIKE '%-00';
ALTER TABLE `tblEmpPersonal` CHANGE `birthday` `birthday` DATE DEFAULT NULL,CHANGE `dateAccomplished` `dateAccomplished` DATE DEFAULT NULL,CHANGE `issuedOn` `issuedOn` DATE DEFAULT NULL;
# Fix Date Value 
# Fix DateTime field in table tblEmpPosition
ALTER TABLE `tblEmpPosition` CHANGE `contractEndDate` `contractEndDate` VARCHAR(20) DEFAULT NULL,CHANGE `effectiveDate` `effectiveDate` VARCHAR(20) DEFAULT NULL,CHANGE `positionDate` `positionDate` VARCHAR(20) DEFAULT NULL,CHANGE `longevityDate` `longevityDate` VARCHAR(20) DEFAULT NULL,CHANGE `firstDayAgency` `firstDayAgency` VARCHAR(20) DEFAULT NULL,CHANGE `firstDayGov` `firstDayGov` VARCHAR(20) DEFAULT NULL,CHANGE `dateIncremented` `dateIncremented` VARCHAR(20) DEFAULT NULL,CHANGE `tmpDateIncremented` `tmpDateIncremented` VARCHAR(20) DEFAULT NULL,CHANGE `tmpPositionDate` `tmpPositionDate` VARCHAR(20) DEFAULT NULL;
UPDATE `tblEmpPosition` SET `contractEndDate` = NULL WHERE `contractEndDate` LIKE '0000%' OR `contractEndDate` LIKE '%-00-%' OR `contractEndDate` LIKE '%-00';
UPDATE `tblEmpPosition` SET `effectiveDate` = NULL WHERE `effectiveDate` LIKE '0000%' OR `effectiveDate` LIKE '%-00-%' OR `effectiveDate` LIKE '%-00';
UPDATE `tblEmpPosition` SET `positionDate` = NULL WHERE `positionDate` LIKE '0000%' OR `positionDate` LIKE '%-00-%' OR `positionDate` LIKE '%-00';
UPDATE `tblEmpPosition` SET `longevityDate` = NULL WHERE `longevityDate` LIKE '0000%' OR `longevityDate` LIKE '%-00-%' OR `longevityDate` LIKE '%-00';
UPDATE `tblEmpPosition` SET `firstDayAgency` = NULL WHERE `firstDayAgency` LIKE '0000%' OR `firstDayAgency` LIKE '%-00-%' OR `firstDayAgency` LIKE '%-00';
UPDATE `tblEmpPosition` SET `firstDayGov` = NULL WHERE `firstDayGov` LIKE '0000%' OR `firstDayGov` LIKE '%-00-%' OR `firstDayGov` LIKE '%-00';
UPDATE `tblEmpPosition` SET `dateIncremented` = NULL WHERE `dateIncremented` LIKE '0000%' OR `dateIncremented` LIKE '%-00-%' OR `dateIncremented` LIKE '%-00';
UPDATE `tblEmpPosition` SET `tmpDateIncremented` = NULL WHERE `tmpDateIncremented` LIKE '0000%' OR `tmpDateIncremented` LIKE '%-00-%' OR `tmpDateIncremented` LIKE '%-00';
UPDATE `tblEmpPosition` SET `tmpPositionDate` = NULL WHERE `tmpPositionDate` LIKE '0000%' OR `tmpPositionDate` LIKE '%-00-%' OR `tmpPositionDate` LIKE '%-00';
ALTER TABLE `tblEmpPosition` CHANGE `contractEndDate` `contractEndDate` DATE DEFAULT NULL,CHANGE `effectiveDate` `effectiveDate` DATE DEFAULT NULL,CHANGE `positionDate` `positionDate` DATE DEFAULT NULL,CHANGE `longevityDate` `longevityDate` DATE DEFAULT NULL,CHANGE `firstDayAgency` `firstDayAgency` DATE DEFAULT NULL,CHANGE `firstDayGov` `firstDayGov` DATE DEFAULT NULL,CHANGE `dateIncremented` `dateIncremented` DATE DEFAULT NULL,CHANGE `tmpDateIncremented` `tmpDateIncremented` DATE DEFAULT NULL,CHANGE `tmpPositionDate` `tmpPositionDate` DATE DEFAULT NULL;
# Fix Date Value 
# Fix DateTime field in table tblEmpRequest
ALTER TABLE `tblEmpRequest` CHANGE `Sig1DateTime` `Sig1DateTime` VARCHAR(20) DEFAULT NULL,CHANGE `Sig2DateTime` `Sig2DateTime` VARCHAR(20) DEFAULT NULL,CHANGE `Sig3DateTime` `Sig3DateTime` VARCHAR(20) DEFAULT NULL,CHANGE `SigFinDateTime` `SigFinDateTime` VARCHAR(20) DEFAULT NULL,CHANGE `requestDate` `requestDate` VARCHAR(20) DEFAULT NULL,CHANGE `statusDate` `statusDate` VARCHAR(20) DEFAULT NULL;
UPDATE `tblEmpRequest` SET `Sig1DateTime` = NULL WHERE `Sig1DateTime` LIKE '0000%' OR `Sig1DateTime` LIKE '%-00-%' OR `Sig1DateTime` LIKE '%-00';
UPDATE `tblEmpRequest` SET `Sig2DateTime` = NULL WHERE `Sig2DateTime` LIKE '0000%' OR `Sig2DateTime` LIKE '%-00-%' OR `Sig2DateTime` LIKE '%-00';
UPDATE `tblEmpRequest` SET `Sig3DateTime` = NULL WHERE `Sig3DateTime` LIKE '0000%' OR `Sig3DateTime` LIKE '%-00-%' OR `Sig3DateTime` LIKE '%-00';
UPDATE `tblEmpRequest` SET `SigFinDateTime` = NULL WHERE `SigFinDateTime` LIKE '0000%' OR `SigFinDateTime` LIKE '%-00-%' OR `SigFinDateTime` LIKE '%-00';
UPDATE `tblEmpRequest` SET `requestDate` = NULL WHERE `requestDate` LIKE '0000%' OR `requestDate` LIKE '%-00-%' OR `requestDate` LIKE '%-00';
UPDATE `tblEmpRequest` SET `statusDate` = NULL WHERE `statusDate` LIKE '0000%' OR `statusDate` LIKE '%-00-%' OR `statusDate` LIKE '%-00';
ALTER TABLE `tblEmpRequest` CHANGE `Sig1DateTime` `Sig1DateTime` DATETIME DEFAULT NULL,CHANGE `Sig2DateTime` `Sig2DateTime` DATETIME DEFAULT NULL,CHANGE `Sig3DateTime` `Sig3DateTime` DATETIME DEFAULT NULL,CHANGE `SigFinDateTime` `SigFinDateTime` DATETIME DEFAULT NULL,CHANGE `requestDate` `requestDate` DATE DEFAULT NULL,CHANGE `statusDate` `statusDate` DATE DEFAULT NULL;
# Fix Date Value 
# Fix DateTime field in table tblEmpTraining
ALTER TABLE `tblEmpTraining` CHANGE `trainingContractDate` `trainingContractDate` VARCHAR(20) DEFAULT NULL,CHANGE `trainingStartDate` `trainingStartDate` VARCHAR(20) DEFAULT NULL,CHANGE `trainingEndDate` `trainingEndDate` VARCHAR(20) DEFAULT NULL;
UPDATE `tblEmpTraining` SET `trainingContractDate` = NULL WHERE `trainingContractDate` LIKE '0000%' OR `trainingContractDate` LIKE '%-00-%' OR `trainingContractDate` LIKE '%-00';
UPDATE `tblEmpTraining` SET `trainingStartDate` = NULL WHERE `trainingStartDate` LIKE '0000%' OR `trainingStartDate` LIKE '%-00-%' OR `trainingStartDate` LIKE '%-00';
UPDATE `tblEmpTraining` SET `trainingEndDate` = NULL WHERE `trainingEndDate` LIKE '0000%' OR `trainingEndDate` LIKE '%-00-%' OR `trainingEndDate` LIKE '%-00';
ALTER TABLE `tblEmpTraining` CHANGE `trainingContractDate` `trainingContractDate` DATE DEFAULT NULL,CHANGE `trainingStartDate` `trainingStartDate` DATE DEFAULT NULL,CHANGE `trainingEndDate` `trainingEndDate` DATE DEFAULT NULL;
# Fix Date Value 
# Fix DateTime field in table tblEmpTravelOrder
ALTER TABLE `tblEmpTravelOrder` CHANGE `dateFiled` `dateFiled` VARCHAR(20) DEFAULT NULL,CHANGE `toDateFrom` `toDateFrom` VARCHAR(20) DEFAULT NULL,CHANGE `toDateTo` `toDateTo` VARCHAR(20) DEFAULT NULL;
UPDATE `tblEmpTravelOrder` SET `dateFiled` = NULL WHERE `dateFiled` LIKE '0000%' OR `dateFiled` LIKE '%-00-%' OR `dateFiled` LIKE '%-00';
UPDATE `tblEmpTravelOrder` SET `toDateFrom` = NULL WHERE `toDateFrom` LIKE '0000%' OR `toDateFrom` LIKE '%-00-%' OR `toDateFrom` LIKE '%-00';
UPDATE `tblEmpTravelOrder` SET `toDateTo` = NULL WHERE `toDateTo` LIKE '0000%' OR `toDateTo` LIKE '%-00-%' OR `toDateTo` LIKE '%-00';
ALTER TABLE `tblEmpTravelOrder` CHANGE `dateFiled` `dateFiled` DATE DEFAULT NULL,CHANGE `toDateFrom` `toDateFrom` DATE DEFAULT NULL,CHANGE `toDateTo` `toDateTo` DATE DEFAULT NULL;
# Fix Date Value 
# Fix DateTime field in table tblEmpTripTicket
ALTER TABLE `tblEmpTripTicket` CHANGE `dateFiled` `dateFiled` VARCHAR(20) DEFAULT NULL,CHANGE `ttDateFrom` `ttDateFrom` VARCHAR(20) DEFAULT NULL,CHANGE `ttDateTo` `ttDateTo` VARCHAR(20) DEFAULT NULL;
UPDATE `tblEmpTripTicket` SET `dateFiled` = NULL WHERE `dateFiled` LIKE '0000%' OR `dateFiled` LIKE '%-00-%' OR `dateFiled` LIKE '%-00';
UPDATE `tblEmpTripTicket` SET `ttDateFrom` = NULL WHERE `ttDateFrom` LIKE '0000%' OR `ttDateFrom` LIKE '%-00-%' OR `ttDateFrom` LIKE '%-00';
UPDATE `tblEmpTripTicket` SET `ttDateTo` = NULL WHERE `ttDateTo` LIKE '0000%' OR `ttDateTo` LIKE '%-00-%' OR `ttDateTo` LIKE '%-00';
ALTER TABLE `tblEmpTripTicket` CHANGE `dateFiled` `dateFiled` DATE DEFAULT NULL,CHANGE `ttDateFrom` `ttDateFrom` DATE DEFAULT NULL,CHANGE `ttDateTo` `ttDateTo` DATE DEFAULT NULL;
# Fix Date Value 
# Fix DateTime field in table tblEmpVoluntaryWork
ALTER TABLE `tblEmpVoluntaryWork` CHANGE `vwDateFrom` `vwDateFrom` VARCHAR(20) DEFAULT NULL,CHANGE `vwDateTo` `vwDateTo` VARCHAR(20) DEFAULT NULL;
UPDATE `tblEmpVoluntaryWork` SET `vwDateFrom` = NULL WHERE `vwDateFrom` LIKE '0000%' OR `vwDateFrom` LIKE '%-00-%' OR `vwDateFrom` LIKE '%-00';
UPDATE `tblEmpVoluntaryWork` SET `vwDateTo` = NULL WHERE `vwDateTo` LIKE '0000%' OR `vwDateTo` LIKE '%-00-%' OR `vwDateTo` LIKE '%-00';
ALTER TABLE `tblEmpVoluntaryWork` CHANGE `vwDateFrom` `vwDateFrom` DATE DEFAULT NULL,CHANGE `vwDateTo` `vwDateTo` DATE DEFAULT NULL;
# Fix DateTime field in table tblFlagCeremony
ALTER TABLE `tblFlagCeremony` CHANGE `flag_datetime` `flag_datetime` VARCHAR(20) DEFAULT NULL;
UPDATE `tblFlagCeremony` SET `flag_datetime` = NULL WHERE `flag_datetime` LIKE '0000%' OR `flag_datetime` LIKE '%-00-%' OR `flag_datetime` LIKE '%-00';
ALTER TABLE `tblFlagCeremony` CHANGE `flag_datetime` `flag_datetime` DATETIME DEFAULT NULL;
# Fix Date Value 
# Fix DateTime field in table tblHolidayYear
ALTER TABLE `tblHolidayYear` CHANGE `holidayDate` `holidayDate` VARCHAR(20) DEFAULT NULL;
UPDATE `tblHolidayYear` SET `holidayDate` = NULL WHERE `holidayDate` LIKE '0000%' OR `holidayDate` LIKE '%-00-%' OR `holidayDate` LIKE '%-00';
ALTER TABLE `tblHolidayYear` CHANGE `holidayDate` `holidayDate` DATE DEFAULT NULL;
# Fix Date Value 
# Fix DateTime field in table tblLocalHoliday
ALTER TABLE `tblLocalHoliday` CHANGE `holidayDate` `holidayDate` VARCHAR(20) DEFAULT NULL;
UPDATE `tblLocalHoliday` SET `holidayDate` = NULL WHERE `holidayDate` LIKE '0000%' OR `holidayDate` LIKE '%-00-%' OR `holidayDate` LIKE '%-00';
ALTER TABLE `tblLocalHoliday` CHANGE `holidayDate` `holidayDate` DATE DEFAULT NULL;
# Fix Date Value 
# Fix DateTime field in table tblNonPermComputationInstance
ALTER TABLE `tblNonPermComputationInstance` CHANGE `startDate` `startDate` VARCHAR(20) DEFAULT NULL,CHANGE `endDate` `endDate` VARCHAR(20) DEFAULT NULL;
UPDATE `tblNonPermComputationInstance` SET `startDate` = NULL WHERE `startDate` LIKE '0000%' OR `startDate` LIKE '%-00-%' OR `startDate` LIKE '%-00';
UPDATE `tblNonPermComputationInstance` SET `endDate` = NULL WHERE `endDate` LIKE '0000%' OR `endDate` LIKE '%-00-%' OR `endDate` LIKE '%-00';
ALTER TABLE `tblNonPermComputationInstance` CHANGE `startDate` `startDate` DATE DEFAULT NULL,CHANGE `endDate` `endDate` DATE DEFAULT NULL;
# Fix Date Value 
# Fix DateTime field in table tblOTComputationInstance
ALTER TABLE `tblOTComputationInstance` CHANGE `startDate` `startDate` VARCHAR(20) DEFAULT NULL,CHANGE `endDate` `endDate` VARCHAR(20) DEFAULT NULL;
UPDATE `tblOTComputationInstance` SET `startDate` = NULL WHERE `startDate` LIKE '0000%' OR `startDate` LIKE '%-00-%' OR `startDate` LIKE '%-00';
UPDATE `tblOTComputationInstance` SET `endDate` = NULL WHERE `endDate` LIKE '0000%' OR `endDate` LIKE '%-00-%' OR `endDate` LIKE '%-00';
ALTER TABLE `tblOTComputationInstance` CHANGE `startDate` `startDate` DATE DEFAULT NULL,CHANGE `endDate` `endDate` DATE DEFAULT NULL;
# Fix Date Value 
# Fix DateTime field in table tblProcess
ALTER TABLE `tblProcess` CHANGE `processDate` `processDate` VARCHAR(20) DEFAULT NULL;
UPDATE `tblProcess` SET `processDate` = NULL WHERE `processDate` LIKE '0000%' OR `processDate` LIKE '%-00-%' OR `processDate` LIKE '%-00';
ALTER TABLE `tblProcess` CHANGE `processDate` `processDate` DATE DEFAULT NULL;
# Fix Date Value 
# Fix DateTime field in table tblProcessedEmployees
ALTER TABLE `tblProcessedEmployees` CHANGE `processDate` `processDate` VARCHAR(20) DEFAULT NULL;
UPDATE `tblProcessedEmployees` SET `processDate` = NULL WHERE `processDate` LIKE '0000%' OR `processDate` LIKE '%-00-%' OR `processDate` LIKE '%-00';
ALTER TABLE `tblProcessedEmployees` CHANGE `processDate` `processDate` DATE DEFAULT NULL;
# Fix Date Value 
# Fix DateTime field in table tblSalarySchedVersion
ALTER TABLE `tblSalarySchedVersion` CHANGE `effectivity` `effectivity` VARCHAR(20) DEFAULT NULL;
UPDATE `tblSalarySchedVersion` SET `effectivity` = NULL WHERE `effectivity` LIKE '0000%' OR `effectivity` LIKE '%-00-%' OR `effectivity` LIKE '%-00';
ALTER TABLE `tblSalarySchedVersion` CHANGE `effectivity` `effectivity` DATE DEFAULT NULL;
# Fix Date Value 
# Fix DateTime field in table tblServiceRecord
ALTER TABLE `tblServiceRecord` CHANGE `serviceFromDate` `serviceFromDate` VARCHAR(20) DEFAULT NULL;
UPDATE `tblServiceRecord` SET `serviceFromDate` = NULL WHERE `serviceFromDate` LIKE '0000%' OR `serviceFromDate` LIKE '%-00-%' OR `serviceFromDate` LIKE '%-00';
ALTER TABLE `tblServiceRecord` CHANGE `serviceFromDate` `serviceFromDate` DATE DEFAULT NULL;
# Fix Date Value 
# Fix DateTime field in table tblTaxDetails
ALTER TABLE `tblTaxDetails` CHANGE `dBirthDate` `dBirthDate` VARCHAR(20) DEFAULT NULL;
UPDATE `tblTaxDetails` SET `dBirthDate` = NULL WHERE `dBirthDate` LIKE '0000%' OR `dBirthDate` LIKE '%-00-%' OR `dBirthDate` LIKE '%-00';
ALTER TABLE `tblTaxDetails` CHANGE `dBirthDate` `dBirthDate` DATE DEFAULT NULL;
# Fix Date Value 
# Fix DateTime field in table tblTempNotification
ALTER TABLE `tblTempNotification` CHANGE `tmpDate` `tmpDate` VARCHAR(20) DEFAULT NULL;
UPDATE `tblTempNotification` SET `tmpDate` = NULL WHERE `tmpDate` LIKE '0000%' OR `tmpDate` LIKE '%-00-%' OR `tmpDate` LIKE '%-00';
ALTER TABLE `tblTempNotification` CHANGE `tmpDate` `tmpDate` DATE DEFAULT NULL;

# Initial data for password: hrmisdost
UPDATE `tblEmpAccount` SET `userPassword` = '$2y$10$GzCYi.q681e.KNCs1RuGRezgHMrxjtQu7tFeY7xwDsLdSa0ztdrvu';

