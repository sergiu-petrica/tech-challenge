import { DateTime } from "luxon";

export function formatJournalDate(date) {
    return DateTime.fromISO(date).toFormat('cccc d LLLL y');
}
